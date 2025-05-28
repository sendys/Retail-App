<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    /* return view('welcome'); */
    return redirect('/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'role:' . implode('|', \App\Models\Role::pluck('name')->toArray())])->group(function () {
    // Grop Role
    Route::get('/role', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::get('/role/create', [App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
    Route::post('/role', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
    Route::get('/role/{role}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/role/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
    Route::delete('/role/{role}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');

    //Group Permission
    Route::get('/permission', [App\Http\Controllers\PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/create', [App\Http\Controllers\PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permission', [App\Http\Controllers\PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/{permission}/edit', [App\Http\Controllers\PermissionController::class, 'edit'])->name('permission.edit');
    Route::put('/permission/{id}', [App\Http\Controllers\PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/permission/{permission}', [App\Http\Controllers\PermissionController::class, 'destroy'])->name('permission.destroy');
});
Route::middleware([
    'auth', 'role:' . implode('|', config('roles.access_user_routes'))])->group(function () {
    // Group User
    Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('/user', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
});
