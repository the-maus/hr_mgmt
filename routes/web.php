<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HrUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){
    Route::redirect('/', '/home');
    Route::view('/home', 'home')->name('home');

    // User profile page
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.profile.update-password');
    Route::post('/user/profile/update-data', [ProfileController::class, 'updateData'])->name('user.profile.update-data');

    // Departments
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/departments/new', [DepartmentController::class, 'new'])->name('departments.new');
    Route::post('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    
    Route::get('/departments/edit/{id}', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::post('/departments/update', [DepartmentController::class, 'update'])->name('departments.update');
    
    Route::get('/departments/delete-confirm/{id}', [DepartmentController::class, 'deleteConfirm'])->name('departments.delete-confirm');
    Route::get('/departments/delete/{id}', [DepartmentController::class, 'delete'])->name('departments.delete');
    
    // HR Collaborators
    Route::get('/hr-users', [HrUserController::class, 'index'])->name('collaborators.hr-users');
    Route::get('/hr-users/new', [HrUserController::class, 'new'])->name('collaborators.new');
    Route::post('/hr-users/new', [HrUserController::class, 'create'])->name('collaborators.create');
    
    Route::get('/hr-users/edit/{id}', [HrUserController::class, 'edit'])->name('collaborators.edit');
    Route::post('/hr-users/edit', [HrUserController::class, 'update'])->name('collaborators.update');
    
    Route::get('/hr-users/delete/{id}', [HrUserController::class, 'delete'])->name('collaborators.delete');
    Route::get('/hr-users/delete-confirm/{id}', [HrUserController::class, 'deleteConfirm'])->name('collaborators.delete-confirm');
});
