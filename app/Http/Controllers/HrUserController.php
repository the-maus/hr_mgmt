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
        ]);

        // create new HR user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 'hr';
        $user->department_id = $request->select_department;
        $user->permissions = '["hr"]';
        $user->save();

        return redirect()->route('collaborators.hr-users')->with('success', 'Collaborator created successfully');
    }
}
