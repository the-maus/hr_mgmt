<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function home()
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not authorized to access this page');

        // collect all info about organization
        $data = [];

        // get total number of collaborators (non-deleted)
        $data['total_collaborators'] = User::whereNull('deleted_at')->count();
        
        // total number of deleted collaborators
        $data['total_collaborators_deleted'] = User::onlyTrashed()->count();
        
        // total salary for all collaborators (non-deleted)
        $data['total_salary'] = User::withoutTrashed()
            ->with('detail')
            ->get()->sum(function($collaborator) {
                return $collaborator->detail->salary;
            });
        $data['total_salary'] = 'R$ '. number_format($data['total_salary'], 2, ',', '.');

        $data['total_collaborators_by_department'] = User::withoutTrashed()
            ->with('department')
            ->get()
            ->groupBy('department_id')
            ->map(function($collaborators) { // array of collaborators from department
                return [
                    'department' => $collaborators->first()->department->name ?? '-',
                    'total' => $collaborators->count()
                ];
            });
                                                        
        $data['total_salary_by_department'] = User::withoutTrashed()
            ->with('department', 'detail')
            ->get()
            ->groupBy('department_id')
            ->map(function($collaborators) { // array of collaborators from department
                return [
                    'department' => $collaborators->first()->department->name ?? '-',
                    'total' => $collaborators->sum(function($collaborator){
                        return $collaborator->detail->salary;
                    })
                ];
            });

        // format salary
        $data['total_salary_by_department'] = $data['total_salary_by_department']->map(function($department){
            return [
                'department' => $department['department'],
                'total'      => 'R$ '. number_format($department['total'], 2, ',', '.')  
            ];
        });

        return view('home', compact('data'));
    }
}
