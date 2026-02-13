<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CollaboratorsController extends Controller
{
    public function index()
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');

        $collaborators = User::withTrashed()
                                ->with('detail', 'department')
                                ->where('role', '<>', 'admin')
                                ->get();

        return view('collaborators.admin-all-collaborators')->with('collaborators', $collaborators);
    }

    public function showDetails($id)
    {
        Auth::user()->can('admin', 'hr') ?: abort(403, 'You are not authorized to access this page');

        // check if id is the same as auther user's
        if (auth()->user()->id === $id)
            return redirect()->route('home');

        $collaborator = User::with('detail', 'department')
                                ->findOrFail($id);

        return view('collaborators.show-details', compact('collaborator'));
    }

    public function delete($id)
    {
        Auth::user()->can('admin', 'hr') ?: abort(403, 'You are not authorized to access this page');

         // check if id is the same as auther user's
        if (auth()->user()->id === $id)
            return redirect()->route('home');

        $collaborator = User::findOrFail($id);

        return view('collaborators.delete-confirm', compact('collaborator'));
    }

    public function deleteConfirm($id)
    {
        Auth::user()->can('admin', 'hr') ?: abort(403, 'You are not authorized to access this page');

         // check if id is the same as auther user's
        if (auth()->user()->id === $id)
            return redirect()->route('home');

        $collaborator = User::findOrFail($id);
        $collaborator->delete();

        return redirect()->route('collaborators.all');
    }

    public function restore($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');

        $collaborator = User::withTrashed()->findOrFail($id);
        $collaborator->restore();

        return redirect()->route('collaborators.all')->with('success', 'Collaborator restored successfully');
    }

    public function home()
    {
        Auth::user()->can('collaborator') ?: abort(403, 'You are not authorized to access this page');

        $collaborator = User::with('detail', 'department')
                                ->where('id', Auth::user()->id)
                                ->first();

        return view('collaborators.show-details', compact('collaborator'));
    }
}
