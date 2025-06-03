<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    /* return view('welcome'); */
    return redirect('/login');
});

Route::get('user/register', [App\Http\Controllers\UserController::class,'register'])->name('user.register');
Route::post('/user/daftar', [App\Http\Controllers\UserController::class,'daftar'])->name('user.daftar');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::middleware([
    'auth', 'role:' . implode('|', config('roles.access_user_routes'))])->group(function () {
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

    //Chart of Account
    Route::get('/accouting', [App\Http\Controllers\CoaController::class, 'index'])->name('akun.index');
    Route::get('/accouting/create', [App\Http\Controllers\CoaController::class, 'create'])->name('akun.create');
    Route::post('/accouting', [App\Http\Controllers\CoaController::class,'store'])->name('akun.store');
    Route::get('/accouting/{accouting}/edit', [App\Http\Controllers\CoaController::class, 'edit'])->name('akun.edit');
    Route::put('/accouting/{id}', [App\Http\Controllers\CoaController::class, 'update'])->name('akun.update');
    Route::delete('/accouting/{accouting}', [App\Http\Controllers\CoaController::class, 'destroy'])->name('akun.destroy');
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

    // Group Customer
    Route::get('/customer', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customer', [App\Http\Controllers\CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/{customer}/edit', [App\Http\Controllers\CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customer/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/{customer}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('customer.destroy');

    // Group Supplier
    Route::get('/supplier', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/supplier/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/supplier', [App\Http\Controllers\SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/supplier/{supplier}/edit', [App\Http\Controllers\SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{supplier}', [App\Http\Controllers\SupplierController::class, 'destroy'])->name('supplier.destroy');
});
