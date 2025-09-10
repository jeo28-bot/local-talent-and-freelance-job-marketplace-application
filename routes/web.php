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

// Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'user_type:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

});

Route::middleware(['auth', 'user_type:employee'])->group(function () {
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employee/postings', [EmployeeController::class, 'postings'])->name('employee.postings');
    Route::get('/employee/transactions', [EmployeeController::class, 'transactions'])->name('employee.transactions');
    Route::get('/employee/applying', [EmployeeController::class, 'applying'])->name('employee.applying');
    Route::get('/employee/saved', [EmployeeController::class, 'saved'])->name('employee.saved');
    Route::get('/employee/messages', [EmployeeController::class, 'messages'])->name('employee.messages');
    Route::get('/employee/notifications', [EmployeeController::class, 'notifications'])->name('employee.notifications');
    Route::get('/employee/profile', [EmployeeController::class, 'profile'])->name('employee.profile');
});

Route::middleware(['auth', 'user_type:client'])->group(function () {
    Route::get('/client', [ClientController::class, 'index'])->name('client.index');

});

Route::get('/nav', function () {
    return view('components.nav');
});

Route::get('/footer', function () {
    return view('components.footer');
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

