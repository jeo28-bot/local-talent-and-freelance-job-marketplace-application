<?php

use Illuminate\Support\Facades\Route;

// main
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// test routes
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Route;

// // main
// Route::get('/', function () {
//     return view('auth.login');
// });

// Auth::routes(['verify' => true]); // 👈 enable email verification

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
//     ->name('home')
//     ->middleware('verified'); // optional: require verified email

// Route::get('/verify', function () {
//     return view('auth.verify');
// });

