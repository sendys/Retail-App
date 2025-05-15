<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    /* return view('welcome'); */
    return redirect('/login');
});

Auth::routes();

Route::middleware(['auth', 'role:admin|user'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
