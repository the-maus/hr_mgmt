<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmAccountEmail;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class HrUserController extends Controller
{
    public function index()
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');

        $collaborators = User::withTrashed()
                            ->with('detail')
                            ->where('role', 'hr')
                            ->get();

        return view('collaborators.hr-users', compact('collaborators'));

    }

    public function new()
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');

        // get all departments
        $departments = Department::all();

        return view('collaborators.add-hr-user', compact('departments'));
    }

    public function create(Request $request)
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');

        // form validation
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255|unique:users,email',
            'select_department' => 'required|exists:departments,id',
            'address'           => 'required|string|max:255',
            'zip_code'          => 'required|string|max:10',
            'city'              => 'required|string|max:50',
            'phone'             => 'required|string|max:50',
            'salary'            => 'required|decimal:2',
            'admission_date'    => 'required|date_format:Y-m-d'
        ]);

        // check if department is default HR
        if ($request->select_department != Department::HR_DEPARTMENT)
            return redirect()->route('home');

        // create user confirmation token
        $token = Str::random(64);

        // create new HR user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->confirmation_token = $token;
        $user->role = 'hr';
        $user->department_id = $request->select_department;
        $user->permissions = '["hr"]';
        $user->save();

        // save user details
        $user->detail()->create([
            'address'        => $request->address,
            'zip_code'       => $request->zip_code,
            'city'           => $request->city,
            'phone'          => $request->phone,
            'salary'         => $request->salary,
            'admission_date' => $request->admission_date,
        ]);

        // send account confirmation email to user
        Mail::to($user->email)->send(new ConfirmAccountEmail(route('confirm-account', $token)));

        return redirect()->route('collaborators.hr-users')->with('success', 'Collaborator created successfully');
    }

    public function edit($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');

        $collaborator = User::with('detail')->where('role', 'hr')->findOrFail($id);

        return view('collaborators.edit', compact('collaborator'));
    }

    public function update(Request $request)
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');

        $request->validate([
            'id'             => 'required|exists:users,id',
            'salary'         => 'required|decimal:2',
            'admission_date' => 'required|date_format:Y-m-d',
        ]);

        $user = User::findOrFail($request->id);
        $user->detail->update([
            'salary' => $request->salary,
            'admission_date' => $request->admission_date,
        ]);

        return redirect()->route('collaborators.hr-users')->with('success', 'Collaborator updated successfully');
    }

    public function delete($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');
        
        $collaborator = User::findOrFail($id);

        return view('collaborators.delete', compact('collaborator'));
    }

    public function deleteConfirm($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');
        
        $collaborator = User::findOrFail($id);
        $collaborator->delete();

        return redirect()->route('collaborators.hr-users')->with('success', 'Collaborator deleted successfully');
    }

    public function restore($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');

        $collaborator = User::withTrashed()->where('role', 'hr')->findOrFail($id);
        $collaborator->restore();

        return redirect()->route('collaborators.hr-users')->with('success', 'Collaborator restored successfully');
    }
}
