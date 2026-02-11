<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){
    Route::redirect('/', '/home');
    Route::view('/home', 'home')->name('home');

    // user profile page
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.profile.update-password');
    Route::post('/user/profile/update-data', [ProfileController::class, 'updateData'])->name('user.profile.update-data');

    // departments
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/departments/new', [DepartmentController::class, 'new'])->name('departments.new');
    Route::post('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    
    Route::get('/departments/edit/{id}', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::post('/departments/update', [DepartmentController::class, 'update'])->name('departments.update');
    
    Route::get('/departments/delete-confirm/{id}', [DepartmentController::class, 'deleteConfirm'])->name('departments.delete-confirm');
    Route::get('/departments/delete/{id}', [DepartmentController::class, 'delete'])->name('departments.delete');
});
