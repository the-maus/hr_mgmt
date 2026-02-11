<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
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
}
