<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Transaction;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VideoCallController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\RoleSwitchController;


Route::get('/', [AnnouncementController::class, 'index']);

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/public_job_postings', [PublicController::class, 'publicPostings'])
    ->name('public.job.postings');

Route::post('/switch-role', [RoleSwitchController::class, 'switch'])
    ->name('switch.role')
    ->middleware('auth');




Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'user_type:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/jobs', [AdminController::class, 'jobs'])->name('admin.jobs');
    Route::get('/admin/announcements', [AdminController::class, 'announcements'])->name('admin.announcements');
    Route::get('/admin/applications', [AdminController::class, 'applications'])->name('admin.applications');
    Route::get('/admin/jobs/{title}', [AdminController::class, 'showJob'])
    ->name('admin.jobs.show');
    Route::get('/admin/job_post', [AdminController::class, 'job_post'])->name('admin.job_post');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/admin/users/export', [AdminController::class, 'export'])->name('admin.users.export');
    Route::get('/admin/public_profile/{name}', [AdminController::class, 'public_profile'])
    ->name('admin.public_profile');
    Route::get('/admin/edit_profile/{name}', [AdminController::class, 'edit_profile'])
    ->name('admin.edit_profile');
    Route::put('/admin/update_profile/{name}', [AdminController::class, 'update_profile'])
    ->name('admin.update_profile');
    Route::post('/admin/update_profile_picture/{name}', [AdminController::class, 'update_profile_picture'])
    ->name('admin.update_profile_picture');
    Route::post('/admin/update_about/{name}', [AdminController::class, 'update_about'])
    ->name('admin.update_about');
    Route::post('/admin/update_skills/{name}', [AdminController::class, 'update_skills'])
    ->name('admin.update_skills');
    Route::post('/admin/upload-files/{name}', [AdminController::class, 'upload_files'])
    ->name('admin.upload_files');
    Route::delete('/admin/uploads/{name}/{id}', [AdminController::class, 'destroy_upload'])
    ->name('admin.uploads.destroy');
    Route::delete('/admin/uploads/{name}/{id}', [AdminController::class, 'destroy_upload'])
    ->name('admin.uploads.destroy');
    Route::delete('/admin/delete/{name}', [AdminController::class, 'delete_user'])->name('admin.delete_user');
    Route::get('/admin/job_post/export', [AdminController::class, 'exportJobPosts'])->name('admin.job_post.export');
    Route::delete('/admin/job_post/{id}', [AdminController::class, 'destroyJobPost'])->name('admin.job_post.destroy');
    Route::get('/admin/applications/export', [AdminController::class, 'exportApplications'])->name('admin.applications.export');
    Route::get('/admin/messages', [AdminController::class, 'messages'])->name('admin.messages');
    Route::get('/admin/messages/export', [App\Http\Controllers\AdminController::class, 'exportMessages'])
    ->name('admin.messages.export');
    Route::get('/admin/users_chat', [AdminController::class, 'users_chat'])->name('admin.users_chats');
    Route::get('/admin/chat', [AdminController::class, 'chat'])->name('admin.chats');
    Route::delete('/admin/delete_chat/{id}', [AdminController::class, 'deleteChat'])->name('admin.delete_chat');
    Route::delete('/admin/delete_conversation/{name}', [AdminController::class, 'deleteConversation'])
    ->name('admin.delete_conversation');
    Route::get('/admin/chat/{name}', [AdminController::class, 'chat'])->name('admin.chat');
    Route::post('/admin/chat/{name}/send', [AdminController::class, 'sendMessage'])->name('admin.send_message');
    Route::get('/admin/users_chat/{name}', [AdminController::class, 'usersChat'])->name('admin.users_chat');
    Route::get('/admin/chat/{name}', [App\Http\Controllers\AdminController::class, 'chat'])->name('admin.chat');
    Route::put('/admin/job-post/{id}/status', [AdminController::class, 'updateJobStatus'])->name('admin.updateJobStatus');


    // Fetch messages for real-time updates
    Route::get('/admin/chat/{name}/messages', [AdminController::class, 'chatMessages'])->name('admin.chat.messages');

    // Fetch chat list for real-time updates
    Route::get('/admin/chats', [AdminController::class, 'chatList'])->name('admin.chat.list');
    Route::delete('/admin/chat/{name}/delete', [AdminController::class, 'deleteUserChat'])->name('admin.deleteUserChat');
    Route::get('/admin/inbox', [AdminController::class, 'inbox'])->name('admin.inbox');
    Route::get('/admin/unread-count', [AdminController::class, 'unreadCount'])
    ->name('admin.unreadCount');
    Route::get('/admin/messages/fetch', [AdminController::class, 'fetchAdminMessages'])
    ->name('admin.messages.fetch');

    
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::put('/admin/transactions/{id}/update-status', [AdminController::class, 'updateTransactionStatus'])
    ->name('admin.transactions.updateStatus');
    Route::delete('/admin/transactions/{id}', [AdminController::class, 'destroy'])
    ->name('admin.transactions.destroy');
   Route::get('/admin/transactions/export', [App\Http\Controllers\AdminController::class, 'exportTransactions'])
    ->name('admin.transactions.export');

    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/reports/export', [AdminController::class, 'exportReports'])->name('admin.reports.export');
    Route::delete('/admin/reports/{id}', [AdminController::class, 'destroyReport'])->name('admin.reports.destroy');
    
    Route::get('/admin/history_log', [AdminController::class, 'history_log'])->name('admin.history_log');
    Route::delete('/admin/history-log/{id}', [AdminController::class, 'destroy_log'])
    ->name('admin.history_log.destroy_log');
   // routes/web.php
    Route::get('/admin/history-log/export', [AdminController::class, 'exportLogs'])->name('admin.history_log.export');

    Route::delete('/admin/applications/{id}', [AdminController::class, 'destroyApplication'])
    ->name('admin.applications.destroy');

    
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
    Route::get('/employee/chat/{name}', [ChatController::class, 'show'])->name('employee.chat');
    Route::post('/employee/chat/{name}/send', [ChatController::class, 'sendMessage'])->name('employee.chat.send');
    Route::get('/employee/chats', [ChatController::class, 'index'])->name('employee.chats');
    Route::get('/employee/chat/{name}/messages', [ChatController::class, 'getMessages'])->name('employee.chat.messages');
    Route::get('/employee/chat/{name}/messages', [ChatController::class, 'fetchMessages'])->name('employee.chat.messages');
    Route::delete('/employee/chat/{name}/delete', [ChatController::class, 'deleteChat'])->name('employee.chat.delete');

    Route::get('/employee/messages', [ChatController::class, 'employeeMessages'])->name('employee.messages');
    Route::get('/employee/messages/fetch', [ChatController::class, 'fetchEmployeeMessages'])->name('employee.messages.fetch');
    Route::get('/employee/applied', [EmployeeController::class, 'applied'])->name('employee.applied');


    Route::prefix('employee')->group(function () {
    Route::get('/transactions', [EmployeeController::class, 'transactions'])
        ->name('employee.transactions');

    Route::get('/transactions/pending', [EmployeeController::class, 'pendingTransactions'])
        ->name('employee.transactions.pending');

    Route::get('/transactions/completed', [EmployeeController::class, 'completedTransactions'])
        ->name('employee.transactions.completed');

    Route::delete('/transactions/{id}', [EmployeeController::class, 'destroyTransaction'])
        ->name('employee.transactions.destroy');

    Route::post('/transactions/request-payout', [EmployeeController::class, 'requestPayout'])
    ->name('employee.transactions.requestPayout');

     // archived route for job posts
        // existing archived applied
        Route::get('/archived/arch_applied', [EmployeeController::class, 'arch_applied'])->name('employee.arch_applied');
        // new route to handle restore
        Route::put('/archived/arch_applicants/{id}/restore', [EmployeeController::class, 'restore_archived_applications'])->name('employee.restore_archived_applications');
        // new route to handle delete
        Route::delete('/archived/arch_applicants/{id}/force-delete', [EmployeeController::class, 'force_delete_archived_applications'])->name('employee.force_delete_archived_applications');
        

    // archived route for transactions
        // existing transactions page
        Route::get('/archived/arch_transactions', [EmployeeController::class, 'arch_transactions'])->name('employee.arch_transactions');
        // new route to handle restore
        Route::put('/archived/arch_transactions/{id}/restore', [EmployeeController::class, 'restore_archived_transactions'])->name('employee.restore_archived_transactions');
        // new route to handle delete
        Route::delete('/archived/arch_transactions/{id}/force-delete', [EmployeeController::class, 'force_delete_archived_transactions'])->name('employee.force_delete_archived_transactions');
    });
    
    Route::post('/employee/block/{id}', [EmployeeController::class, 'blockUser'])->name('employee.block');
    Route::delete('/employee/unblock/{id}', [\App\Http\Controllers\EmployeeController::class, 'unblockUser'])
    ->name('employee.unblock')
    ->middleware('auth');
    
    Route::get('/employee/notification/{id}/open', [EmployeeController::class, 'openNotification'])
    ->name('employee.notification.open');
    Route::delete('/employee/notifications/delete/{id}', [EmployeeController::class, 'deleteNotification'])
    ->name('employee.notification.delete');

    // video call
    Route::get('/employee/video-call', [EmployeeController::class, 'videoCall'])->name('employee.video-call');
    // video call route with receiver ID
    Route::get('/employee/video-call/{receiver}', [EmployeeController::class, 'videoCall'])->name('employee.video-call');
    Route::get('/employee/check-new-notifications', [EmployeeController::class, 'checkNewNotifications']);

    // ratings and reviews route for employee
    Route::get('employee/ratings/{username}', [EmployeeController::class, 'showRatings'])
    ->name('employee.ratings');
    


});

Route::middleware(['auth', 'user_type:client'])->group(function () {
    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/postings', [JobPostController::class, 'postings'])->name('client.postings');
    Route::get('/client/applicants', [ClientController::class, 'applicants'])
     ->name('client.applicants');
    Route::get('/client/transactions', [ClientController::class, 'transactions'])->name('client.transactions');
    Route::get('/client/messages', [ClientController::class, 'messages'])->name('client.messages');
    Route::get('/client/notifications', [ClientController::class, 'notifications'])->name('client.notifications');
    Route::get('/client/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::get('/client/public_profile', [ClientController::class, 'public_profile'])->name('client.public_profile');
    
     // List all jobs page
    Route::get('/client/jobs', [ClientController::class, 'jobs'])->name('client.jobs');

    // Single job detail page
    Route::get('/client/jobs/{slug}', [ClientController::class, 'showJob'])->name('client.jobs.show');

    Route::get('/client/public_profile/{name}', [ClientController::class, 'publicProfile'])->name('client.public_profile');
    Route::get('/client/chat/{name}', [ChatController::class, 'show'])->name('client.chat');
    Route::post('/client/chat/{name}/send', [ChatController::class, 'sendMessage'])->name('client.chat.send');
    Route::get('/client/chats', [ChatController::class, 'index'])->name('client.chats');
    Route::get('/client/chat/{name}/messages', [ChatController::class, 'getMessages'])->name('client.chat.messages');
    Route::get('/client/chat/{name}/messages', [ChatController::class, 'fetchMessages'])->name('client.chat.messages');
    Route::delete('/client/chat/{name}/delete', [ChatController::class, 'deleteChat'])->name('client.chat.delete');
    Route::get('/client/messages', [ChatController::class, 'recentMessages'])->name('client.messages');
    Route::get('client/messages/fetch', [ChatController::class, 'fetchRecentChats'])->name('client.messages.fetch');
    Route::get('/client/messages', [ChatController::class, 'clientMessages'])->name('client.messages');
    Route::get('/client/messages/fetch', [ChatController::class, 'fetchRecentChats'])->name('client.messages.fetch');

    Route::prefix('client')->group(function () {
    // Route::get('/transactions', [ClientController::class, 'transactions'])
    //     ->name('employee.transactions');

    Route::get('/transactions/pending', [ClientController::class, 'pendingTransactions'])
        ->name('client.transactions.pending');

    Route::get('/transactions/completed', [ClientController::class, 'completedTransactions'])
        ->name('client.transactions.completed');

    Route::delete('/transactions/{id}', [ClientController::class, 'destroyTransaction'])
        ->name('client.transactions.destroy');

    // archived route for job posts
        // existing archived jobs page
        Route::get('/archived/arch_jobs', [ClientController::class, 'arch_jobs'])->name('client.arch_jobs');
        // new route to handle update
        Route::put('/archived/arch_jobs/{id}', [ClientController::class, 'update_archived_job'])->name('client.update_archived_job');
        // new route to handle restore
        Route::put('/archived/arch_jobs/{id}/restore', [ClientController::class, 'restore_archived_job'])->name('client.restore_archived_job');
        // new route to handle delete
        Route::delete('/archived/arch_jobs/{id}/delete',[ClientController::class, 'force_delete_archived_job'])->name('client.force_delete_archived_job');

    // archived route for job posts
        // existing archived applicants
        Route::get('/archived/arch_applicants', [ClientController::class, 'arch_applicants'])->name('client.arch_applicants');
        // new route to handle update
        Route::put('/archived/arch_applicants/{id}', [ClientController::class, 'update_archived_applicants'])->name('client.update_archived_applicants');
        // new route to handle restore
        Route::put('/archived/arch_applicants/{id}/restore', [ClientController::class, 'restore_archived_applicants'])->name('client.restore_archived_applicants');
        // new route to handle delete
        Route::delete('/archived/arch_applicants/{id}/delete',[ClientController::class, 'force_delete_archived_applicants'])->name('client.force_delete_archived_applicants');

    // archived route for transactions
        // existing transactions page
        Route::get('/archived/arch_transactions', [ClientController::class, 'arch_transactions'])->name('client.arch_transactions');
        // new route to handle restore
        Route::put('/archived/arch_transactions/{id}/restore', [ClientController::class, 'restore_archived_transaction'])->name('client.restore_archived_transaction');
        // new route to handle delete
        Route::delete('/archived/arch_transactions/{id}/delete',[ClientController::class, 'force_delete_archived_transaction'])->name('client.force_delete_archived_transaction');
    });

    // Route::post('/client/transactions/{id}/mark-paid', [ClientController::class, 'markAsPaid'])
    // ->name('client.transactions.markAsPaid');
    Route::post('/client/transactions/{id}/submit-payment', [ClientController::class, 'markAsSubmitted'])
    ->name('client.transactions.submitPayment');


    Route::get('/client/applicants', [ClientController::class, 'indexForClient'])
    ->name('client.applicants');

    // Add this for the paginated fetch (AJAX)
    Route::get('/employee/messages/fetch-paginated', [ChatController::class, 'fetchEmployeeMessagesPaginated'])
    ->name('employee.messages.paginated');

    Route::post('/client/block/{id}', [ClientController::class, 'blockUser'])
    ->name('client.block')
    ->middleware('auth');
    Route::delete('/client/unblock/{id}', [ClientController::class, 'unblockUser'])
    ->name('client.unblock')
    ->middleware('auth');
    Route::get('/client/notification/open/{id}', [ClientController::class, 'openNotification'])
     ->name('client.notification.open');
    Route::delete('/client/notifications/delete/{id}', [ClientController::class, 'deleteNotification'])
    ->name('client.notification.delete');

    // video call route
    Route::get('/client/video-call', [ClientController::class, 'videoCall'])->name('client.video-call');
    // video call route with receiver ID
    Route::get('/client/video-call/{receiver}', [ClientController::class, 'videoCall'])->name('client.video-call');
    Route::get('/client/check-new-notifications', [ClientController::class, 'checkNewNotifications']);

    // ratings and reviews route for client
    Route::get('client/ratings/{username}', [ClientController::class, 'showRatings'])
    ->name('client.ratings');
});

Route::post('/report', [ReportController::class, 'store'])->name('reports.store');

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
Route::delete('/profile/uploads/{id}', [ProfileController::class, 'destroyUpload'])->name('uploads.destroy');

Route::post('/profile/about/update', [ProfileController::class, 'updateAbout'])
    ->name('profile.updateAbout')
    ->middleware('auth');


// Employee chat menu JSON
Route::get('/employee/fetch-messages-json', [ChatController::class, 'fetchEmployeeMessages'])->name('employee.fetchMessagesJson');

// Client chat menu JSON
Route::get('/client/fetch-messages-json', [ChatController::class, 'fetchRecentChats'])->name('client.fetchMessagesJson');

Route::post('/video-call/signal', function (Illuminate\Http\Request $request) {
    broadcast(new App\Events\VideoCallSignal($request->signal, auth()->id(), $request->to));
    return ['status' => 'ok'];
});


Route::post('/start-call', [CallController::class, 'startCall']);


Route::post('/video-call/start', [VideoCallController::class, 'start']);
Route::get('/video-call/join/{roomName}', [VideoCallController::class, 'join']);
Route::post('/send-incoming-call/{receiverId}', [CallController::class, 'sendIncomingCall']);

Route::get('/chat/unread-vc', [ChatController::class, 'unreadVC']);
Route::post('/chat/mark-vc-read/{id}', [ChatController::class, 'markRead']);

Route::get('/user-status/{id}', [UserController::class, 'status']);



Route::post('/keep-online', [UserController::class, 'keepOnline'])->middleware('auth');
Route::post('/check-user-status', [UserController::class, 'check']);
Route::post('/set-offline', [UserController::class, 'setOffline'])->middleware('auth');


// ratings and reviews routes
Route::post('/users/{user}/reviews', [RatingController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');
Route::put('/reviews/{id}', [RatingController::class, 'update'])->name('reviews.update');
