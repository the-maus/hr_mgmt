<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CollaboratorsController;
use App\Http\Controllers\ConfirmAccountController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HrManagementController;
use App\Http\Controllers\HrUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){
    Route::redirect('/', '/home');
    Route::get('/home', function(){
        if (auth()->user()->role === 'admin')
            return redirect()->route('admin.home');
        elseif (auth()->user()->role === 'hr')
            return redirect()->route('hr.management.home');
        else
            return redirect()->route('collaborator');
    })->name('home');

    // User profile page
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.profile.update-password');
    Route::post('/user/profile/update-data', [ProfileController::class, 'updateData'])->name('user.profile.update-data');
    Route::post('/user/profile/update-address', [ProfileController::class, 'updateAddress'])->name('user.profile.update-address');

    // Departments (admin view)
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/departments/new', [DepartmentController::class, 'new'])->name('departments.new');
    Route::post('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    
    Route::get('/departments/edit/{id}', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::post('/departments/update', [DepartmentController::class, 'update'])->name('departments.update');
    
    Route::get('/departments/delete-confirm/{id}', [DepartmentController::class, 'deleteConfirm'])->name('departments.delete-confirm');
    Route::get('/departments/delete/{id}', [DepartmentController::class, 'delete'])->name('departments.delete');
    
    // HR Collaborators (role:hr) (admin view)
    Route::get('/hr-users', [HrUserController::class, 'index'])->name('collaborators.hr-users');
    Route::get('/hr-users/new', [HrUserController::class, 'new'])->name('collaborators.hr.new');
    Route::post('/hr-users/new', [HrUserController::class, 'create'])->name('collaborators.hr.create');
    
    Route::get('/hr-users/edit/{id}', [HrUserController::class, 'edit'])->name('collaborators.hr.edit');
    Route::post('/hr-users/edit', [HrUserController::class, 'update'])->name('collaborators.hr.update');
    
    Route::get('/hr-users/delete/{id}', [HrUserController::class, 'delete'])->name('collaborators.hr.delete');
    Route::get('/hr-users/delete-confirm/{id}', [HrUserController::class, 'deleteConfirm'])->name('collaborators.hr.delete-confirm');
    Route::get('/hr-users/restore/{id}', [HrUserController::class, 'restore'])->name('collaborators.hr.restore');
    
    // General Collaborators (role:collaborator) HR Dashboard (hr view)
    Route::get('/hr-users/management/home', [HrManagementController::class, 'home'])->name('hr.management.home');
    Route::get('/hr-users/management/new-collaborator', [HrManagementController::class, 'newCollaborator'])->name('hr.management.new-collaborator');
    Route::post('/hr-users/management/new-collaborator', [HrManagementController::class, 'createCollaborator'])->name('hr.management.create-collaborator');
    Route::get('/hr-users/management/edit-collaborator/{id}', [HrManagementController::class, 'editCollaborator'])->name('hr.management.edit-collaborator');
    Route::post('/hr-users/management/update-collaborator/', [HrManagementController::class, 'updateCollaborator'])->name('hr.management.update-collaborator');
    Route::get('/hr-users/management/details/{id}', [HrManagementController::class, 'showDetails'])->name('hr.management.details');

    Route::get('/hr-users/management/delete/{id}', [HrManagementController::class, 'deleteCollaborator'])->name('hr.management.delete');
    Route::get('/hr-users/management/delete-confirm/{id}', [HrManagementController::class, 'deleteCollaboratorConfirm'])->name('hr.management.delete-confirm');
    Route::get('/hr-users/management/restore/{id}', [HrManagementController::class, 'restoreCollaborator'])->name('hr.management.restore');

    // All Collaborators (admin view)
    Route::get('/collaborators', [CollaboratorsController::class, 'index'])->name('collaborators.all');
    Route::get('/collaborators/details/{id}', [CollaboratorsController::class, 'showDetails'])->name('collaborators.details');
    
    Route::get('/collaborators/delete/{id}', [CollaboratorsController::class, 'delete'])->name('collaborators.delete');
    Route::get('/collaborators/delete-confirm/{id}', [CollaboratorsController::class, 'deleteConfirm'])->name('collaborators.delete-confirm');
    Route::get('/collaborators/restore/{id}', [CollaboratorsController::class, 'restore'])->name('collaborators.restore');
    
    Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');

    // Normal collaboratos
    Route::get('/collaborator', [CollaboratorsController::class, 'home'])->name('collaborator');
});
    
Route::middleware('guest')->group(function(){
    // e-mail confirmation and password definition
    Route::get('/confirm-account/{token}', [ConfirmAccountController::class, 'confirmAccount'])->name('confirm-account');
    Route::post('/confirm-account', [ConfirmAccountController::class, 'confirmAccountSubmit'])->name('confirm-account-submit');
});