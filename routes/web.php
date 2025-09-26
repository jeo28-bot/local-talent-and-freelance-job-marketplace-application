<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\ProfileController;


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
    Route::get('/employee/jobs', [EmployeeController::class, 'jobs'])->name('employee.jobs');
    Route::get('/employee/applied', [EmployeeController::class, 'applied'])->name('employee.applied');
    Route::get('/employee/saved', [EmployeeController::class, 'saved'])->name('employee.saved');
    Route::get('/employee/messages', [EmployeeController::class, 'messages'])->name('employee.messages');
    Route::get('/employee/notifications', [EmployeeController::class, 'notifications'])->name('employee.notifications');
    Route::get('/employee/profile', [EmployeeController::class, 'profile'])->name('employee.profile');
    Route::get('/employee/jobs/{slug}', [EmployeeController::class, 'showJob'])->name('employee.jobs.show');
    Route::get('/employee/public_profile', [EmployeeController::class, 'public_profile'])->name('employee.public_profile');

    // web.php
Route::get('/employee/public_profile/{name}', [EmployeeController::class, 'publicProfile'])
    ->name('employee.public_profile');



});

Route::middleware(['auth', 'user_type:client'])->group(function () {
    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/postings', [ClientController::class, 'postings'])->name('client.postings');
    Route::get('/client/applicants', [ClientController::class, 'applicants'])->name('client.applicants');
    Route::get('/client/transactions', [ClientController::class, 'transactions'])->name('client.transactions');
    Route::get('/client/messages', [ClientController::class, 'messages'])->name('client.messages');
    Route::get('/client/notifications', [ClientController::class, 'notifications'])->name('client.notifications');
    Route::get('/client/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::get('/client/public_profile', [ClientController::class, 'public_profile'])->name('client.public_profile');
    
     // List all jobs page
    Route::get('/client/jobs', [ClientController::class, 'jobs'])->name('client.jobs');

    // Single job detail page
     Route::get('/client/jobs/{slug}', [ClientController::class, 'showJob'])->name('client.jobs.show');

});

Route::get('/nav', function () {
    return view('components.nav');
});

Route::get('/footer', function () {
    return view('components.footer');
});

Route::post('/job-posts', [JobPostController::class, 'store'])->name('job_posts.store');

Route::get('/client/postings', function () {
    return view('client.postings');
})->name('client.postings');

Route::get('/client/postings', [JobPostController::class, 'postings'])->name('client.postings');

Route::put('/job-posts/{job}', [JobPostController::class, 'update'])->name('job_posts.update');

Route::delete('/job-posts/{id}', [JobPostController::class, 'destroy'])->name('job_posts.destroy');


Route::put('/job-posts/{job}/update-status', [JobPostController::class, 'updateStatus'])->name('job_posts.update_status');

// save jobs routes
Route::post('/employee/jobs/{id}/save', [EmployeeController::class, 'saveJob'])->name('employee.jobs.save');
Route::get('/employee/saved', [EmployeeController::class, 'saved'])->name('employee.saved');
Route::get('/jobs/{id}', [JobPostController::class, 'show'])->name('jobs.show');


// job application routes
Route::post('/jobs/{id}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');
Route::middleware(['auth'])->group(function () {
    // List of applicants
    Route::get('/client/applicants', [JobApplicationController::class, 'indexForClient'])
        ->name('client.applicants');

    // Update status (Accept / Reject)
    Route::post('/applications/{id}/status', [JobApplicationController::class, 'updateStatus'])
        ->name('applications.updateStatus');
});
Route::delete('/applications/{id}', [JobApplicationController::class, 'destroy'])->name('applications.destroy');
Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])
    ->name('applications.store')
    ->middleware('auth');
Route::patch('/applications/{id}/cancel', [JobApplicationController::class, 'cancel'])
    ->name('applications.cancel');
Route::delete('/job-applications/{id}', [JobApplicationController::class, 'destroy'])->name('job-applications.destroy');


// profile updates routes
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/skills', [App\Http\Controllers\ProfileController::class, 'updateSkills'])->name('profile.updateSkills');
Route::post('/profile/picture', [App\Http\Controllers\ProfileController::class, 'updatePicture'])->name('profile.updatePicture');
Route::post('/profile/upload-files', [ProfileController::class, 'uploadFiles'])->name('profile.uploadFiles');
Route::delete('/profile/uploads/{id}', [ProfileController::class, 'destroyUpload'])
    ->name('uploads.destroy');
Route::delete('/profile/uploads/{id}', [ProfileController::class, 'destroyUpload'])->name('uploads.destroy');
Route::post('/profile/about/update', [ProfileController::class, 'updateAbout'])
    ->name('profile.updateAbout')
    ->middleware('auth');