<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmAccountEmail;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class HrManagementController extends Controller
{
    public function home()
    {
        Auth::user()->can('hr') ?:abort(403, 'You are not authorized to access this page');

        // collaborators that are not admin nor hr
        $collaborators = User::with('detail', 'department')
                            ->where('role', 'collaborator')
                            ->withTrashed()
                            ->get();

        return view('collaborators.collaborators', compact('collaborators'));

    }

    public function newCollaborator()
    {
        Auth::user()->can('hr') ?:abort(403, 'You are not authorized to access this page');

        $departments = Department::where('id','>', Department::HR_DEPARTMENT)->get();

        // if there's no departments, abort request
        if($departments->count() === 0)
            abort(403, 'There are no departments to add a new collaborator. Please contact system admin to add a new department.');

        return view('collaborators.add-collaborator', compact('departments'));
    }

    public function createCollaborator(Request $request)
    {
        Auth::user()->can('hr') ?: abort(403, 'You are not authorized to access this page');

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

        // cant be ADMIN|HR departments
        if ($request->select_department <= Department::HR_DEPARTMENT)
            return redirect()->route('home');

        // create user confirmation token
        $token = Str::random(64);

        // create new HR user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->confirmation_token = $token;
        $user->role = 'collaborator';
        $user->department_id = $request->select_department;
        $user->permissions = '["collaborator"]';
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

        return redirect()->route('hr.management.home')->with('success', 'Collaborator created successfully');
    }

    public function editCollaborator($id)
    {
        Auth::user()->can('hr') ?: abort(403, 'You are not authorized to access this page');

        $collaborator = User::with('detail', 'department')->findOrFail($id);
        $departments = Department::where('id' , '>' , Department::HR_DEPARTMENT)->get();

        return view('collaborators.edit-collaborator', compact('collaborator', 'departments'));
    }

    public function updateCollaborator(Request $request)
    {
        Auth::user()->can('hr') ?: abort(403, 'You are not authorized to access this page');

        $request->validate(
            [
                'id' => 'required|exists:users,id',
                'salary' => 'required|decimal:2',
                'admission_date' => 'required|date_format:Y-m-d',
                'select_department' => 'required|exists:departments,id'
            ]
        );

        // cant be ADMIN|HR departments
        if ($request->select_department <= Department::HR_DEPARTMENT)
            return redirect()->route('home');

        $user = User::with('detail')->findOrFail($request->id);
        $user->detail->salary = $request->salary;
        $user->detail->admission_date = $request->admission_date;
        $user->department_id = $request->select_department;

        $user->save();
        $user->detail->save();

        return redirect()->route('hr.management.home')->with('success', 'Collaborator updated successfully');
    }

    public function showDetails($id)
    {
        Auth::user()->can('hr') ?: abort(403, 'You are not authorized to access this page');

        $collaborator = User::with('detail', 'department')->findOrFail($id);

        return view('collaborators.show-details', compact('collaborator'));
    }

    public function deleteCollaborator($id)
    {
        Auth::user()->can('hr') ?: abort(403, 'You are not authorized to access this page');

        $collaborator = User::findOrFail($id);

        // display confirmation page
        return view('collaborators.delete-collaborator', compact('collaborator'));
    }

    public function deleteCollaboratorConfirm($id)
    {
        Auth::user()->can('hr') ?: abort(403, 'You are not authorized to access this page');

        $collaborator = User::findOrFail($id);
        $collaborator->delete();

        return redirect()->route('hr.management.home')->with('success', 'Collaborator deleted successfully');
    }

    public function restoreCollaborator($id)
    {
        Auth::user()->can('hr') ?: abort(403, 'You are not authorized to access this page');

        $collaborator = User::withTrashed()->findOrFail($id);
        $collaborator->restore();

        return redirect()->route('hr.management.home')->with('success', 'Collaborator restored successfully');
    }
}
