<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HrUserController extends Controller
{
    public function index()
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');

        $collaborators = User::where('role', 'hr')->get();

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

        // create new HR user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
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

        return redirect()->route('collaborators.hr-users')->with('success', 'Collaborator created successfully');
    }
}
