<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;


Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'user_type:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

});

Route::middleware(['auth', 'user_type:employee'])->group(function () {
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');

});

Route::middleware(['auth', 'user_type:client'])->group(function () {
    Route::get('/client', [ClientController::class, 'index'])->name('client.index');

});



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

