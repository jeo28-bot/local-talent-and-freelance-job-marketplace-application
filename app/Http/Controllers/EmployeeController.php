<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SavedJob;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\BlockedUser;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Announcement;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function index() {
        $announcements = Announcement::where('status', 'active')
            ->whereIn('audience', ['employee', 'all']) // <-- only employee or all
            ->whereDate('release_date', '<=', Carbon::now()) // only past or today
            ->orderBy('release_date', 'desc')
            ->take(3)
            ->get();

        return view('employee.index', compact('announcements'));
    }


    public function ratings() {
        return view('employee.ratings');
    }

    public function showRatings($username)
    {
        // Get the user by slug/username
        $user = User::where('name', $username)->firstOrFail();

        // Get all received ratings
        $ratings = $user->receivedRatings()->latest()->get();

        // Count & average
        $totalRatings = $ratings->count();
        $averageRating = $ratings->avg('rating');

        // Pass data to the view
        return view('employee.ratings', compact('user', 'ratings', 'totalRatings', 'averageRating'));
    }

    public function postings(Request $request)
    {
        $user = auth()->user();

        $query = JobPost::with('client');

        // 🔎 Search filter
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('job_title', 'like', "%$q%")
                    ->orWhere('job_type', 'like', "%$q%")
                    ->orWhere('job_pay', 'like', "%$q%")
                    ->orWhere('salary_release', 'like', "%$q%")
                    ->orWhere('short_description', 'like', "%$q%")
                    ->orWhere('skills_required', 'like', "%$q%")
                    ->orWhere('status', 'like', "%$q%")
                    ->orWhereHas('client', function ($clientQuery) use ($q) {
                        $clientQuery->where('name', 'like', "%$q%");
                    });
            });
        }

        // 📍 Location filter
        if ($request->filled('location')) {
            $query->where('job_location', 'like', "%{$request->location}%");
        }

        // ❌ Exclude blocked clients
        if ($user) {
            // User → blocked client
            $blockedClientIds = BlockedUser::where('user_id', $user->id)
                ->pluck('blocked_user_id')
                ->toArray();

            // Client → blocked user
            $clientsWhoBlockedMe = BlockedUser::where('blocked_user_id', $user->id)
                ->pluck('user_id')
                ->toArray();

            // Merge all
            $allBlockedClientIds = array_unique(array_merge($blockedClientIds, $clientsWhoBlockedMe));

            if (!empty($allBlockedClientIds)) {
                $query->whereNotIn('client_id', $allBlockedClientIds);
            }
        }

        // 🆕 Always show newest jobs first
        $query->orderBy('created_at', 'desc');

        // 📑 Pagination
        $posts = $query->paginate(3);

        return view('employee.postings', compact('posts'));
    }


    public function public_profile()
    {
        return view('employee.public_profile');
    }
    public function transactions()
    {
        $user = auth()->user();

        // Only show 3 per page
        $transactions = \App\Models\Transaction::where('employee_id', $user->id)
            ->latest()
            ->paginate(3);

        return view('employee.transactions', compact('transactions'));
    }
    public function pendingTransactions(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('q');

        // ✅ Base query for employee's non-completed transactions
        $transactionsQuery = \App\Models\Transaction::where('employee_id', $user->id)
            ->whereIn('status', ['pending', 'paid', 'requested'])
            ->with('client') // eager-load client
            ->latest();

        // ✅ If user searched something, filter by job title, client name, amount, or status
        if (!empty($search)) {
            $transactionsQuery->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                ->orWhereHas('client', function ($clientQuery) use ($search) {
                    $clientQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('amount', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // ✅ Paginate and keep query string
        $transactions = $transactionsQuery->paginate(3)->withQueryString();

        return view('employee.transactions.pending', compact('transactions'));
    }


    public function completedTransactions(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('q');

        // ✅ Base query for completed transactions
        $transactionsQuery = \App\Models\Transaction::where('employee_id', $user->id)
            ->where('status', 'completed')
            ->with('client') // eager load client info
            ->latest();

        // ✅ Apply search filter if query exists
        if (!empty($search)) {
            $transactionsQuery->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%") // 🔥 Search by transaction ID
                ->orWhereHas('client', function ($clientQuery) use ($search) {
                    $clientQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('amount', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // ✅ Paginate and preserve query string
        $transactions = $transactionsQuery->paginate(3)->withQueryString();

        return view('employee.transactions.completed', compact('transactions'));
    }

    public function destroyTransaction($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaction deleted successfully.');
    }
    public function requestPayout(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'payment_method' => 'required|string',
            'reference_no' => 'required|string',
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);

        $transaction->update([
            'payment_method' => $request->payment_method,
            'reference_no' => $request->reference_no,
            'status' => 'requested',
        ]);

        // 🔥 Create notification
        Notification::create([
            'user_id' => $transaction->client_id,
            'type'    => 'payout_request',
            'title'   => 'Payout Request',
            'body'    => 'An employee has requested a payout.',
            'data'    => [
                'employee_id' => auth()->id(),
                'transaction_id' => $transaction->id,
            ],
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Payout request submitted successfully.');
    }

    
    public function jobs()
    {
        return view('employee.jobs');
    }
    
    public function applied(Request $request)
    {
        $search = $request->input('q');

        $applications = \App\Models\JobApplication::with(['job', 'user'])
            ->where('user_id', Auth::id())
           ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('job', fn($jobQuery) => $jobQuery->where('job_title', 'like', "%{$search}%"))
                    ->orWhereHas('user', fn($userQuery) => $userQuery->where('name', 'like', "%{$search}%"))
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT('2025', id) LIKE ?", ["%{$search}%"]);

                    // Optional: date search
                    if (\Carbon\Carbon::hasFormat($search, 'Y-m-d')) {
                        $q->orWhereDate('created_at', $search);
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // keeps search query in pagination links

        return view('employee.applied', compact('applications', 'search'));
    }
    public function openNotification($id)
    {
        $notification = \App\Models\Notification::findOrFail($id);

        // Mark as read
        $notification->update(['is_read' => true]);

        // Decode data
        $noteData = is_array($notification->data)
            ? $notification->data
            : json_decode($notification->data, true);

        // 1️⃣ Check if this is a job application notification
        $applicationId = $noteData['application_id'] ?? null;

        if ($applicationId) {
            return redirect()->route('employee.applied', ['q' => $applicationId]);
        }

        // 2️⃣ NEW FLOW: Payment completed → redirect to completed transactions
        $transactionId = $noteData['transaction_id'] ?? null;

        if ($notification->type === 'payment_completed' && $transactionId) {
            return redirect()->route('employee.transactions.completed', ['q' => $transactionId]);
        }

        // 3️⃣ Fallback
        return redirect()->back();
    }

    public function deleteNotification($id)
    {
        $notification = \App\Models\Notification::where('id', $id)
            ->where('user_id', auth()->id()) // ensure it's the logged-in user's notification
            ->first();

        if ($notification) {
            $notification->delete();
            return redirect()->back()->with('success', 'Notification deleted successfully.');
        }

        return redirect()->back()->with('error', 'Notification not found.');
    }





    public function messages()
    {
        return view('employee.messages');
    }
    public function notifications()
    {
        $user = auth()->user();

        $today = Carbon::today(); // only date, no time

        $announcements = \App\Models\Announcement::where('status', 'active')
            ->where(function($q) {
                $q->where('audience', 'employee')
                ->orWhere('audience', 'all');
            })
            ->whereDate('release_date', '<=', Carbon::today()) // compare only the date part
            ->orderBy('release_date', 'desc')
            ->get();

        $notifications = \App\Models\Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('employee.notifications', compact('notifications', 'announcements'));
    }
    



    public function checkNewNotifications(Request $request)
    {
        $userId = auth()->id();

        // Check if there are unread notifications for this user
        $hasNew = \App\Models\Notification::where('user_id', $userId)
                                        ->where('is_read', false)
                                        ->exists();

        return response()->json(['has_new' => $hasNew]);
    }

    

    public function profile()
    {
        $user = Auth::user();

        // Get blocked users by this employee
        $blockedUsers = BlockedUser::where('user_id', $user->id)
            ->with('blocked') // eager load blocked user info
            ->orderBy('blocked_at', 'desc')
            ->get();

        return view('employee.profile', compact('blockedUsers'));
    }
    public function showJob($slug)
    {
        $job = JobPost::all()->first(function ($job) use ($slug) {
            return Str::slug($job->job_title) === $slug;
        });

        if (!$job) {
            abort(404);
        }

        return view('employee.jobs', compact('job'));
    }

    // save function
    public function saved(Request $request)
    {
        $search = $request->input('q');

        $savedJobsQuery = auth()->user()->savedJobs()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('job_title', 'LIKE', "%{$search}%")
                    ->orWhere('job_location', 'LIKE', "%{$search}%")
                    ->orWhere('job_type', 'LIKE', "%{$search}%")
                    ->orWhere('job_pay', 'LIKE', "%{$search}%")
                    ->orWhere('salary_release', 'LIKE', "%{$search}%")
                    ->orWhere('short_description', 'LIKE', "%{$search}%")
                    ->orWhere('skills_required', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery->where('name', 'LIKE', "%{$search}%");
                    });
                });
            });

        $savedJobs = $savedJobsQuery->paginate(3)->withQueryString();

        return view('employee.saved', compact('savedJobs', 'search'));
    }


    public function saveJob($id)
    {
        $job = JobPost::findOrFail($id);
        $user = auth()->user();

        if ($user->savedJobs->contains($job->id)) {
            // Unsave
            $user->savedJobs()->detach($job->id);
            $message = 'Job unsaved!';
        } else {
            // Save
            $user->savedJobs()->attach($job->id);
            $message = 'Job saved!';
        }

        return redirect()->back()->with('success', $message);
    }

    public function savedJobs()
    {
        $employeeId = Auth::id(); // current logged in employee
        $posts = SavedJob::where('employee_id', $employeeId)
                    ->with('job') // eager load the job post
                    ->get()
                    ->pluck('job'); // only return the JobPost models

        return view('employee.saved', compact('posts'));
    }
    public function appliedJobs()
    {
        $applications = JobApplication::where('user_id', auth()->id())
            ->with('job') // eager load jobs
            ->paginate(10); // only 10 per page

        return view('employee.applied', compact('applications'));
    }

    // EmployeeController
    public function publicProfile($name)
    {
        $decodedName = urldecode($name);
        $user = \App\Models\User::where('name', $decodedName)->firstOrFail();
        $viewer = auth()->user();

        // Check if the **profile user blocked the viewer**
        $isBlockedByUser = \App\Models\BlockedUser::where('user_id', $user->id)
                            ->where('blocked_user_id', $viewer->id)
                            ->exists();


        // Check if the currently logged-in user has blocked this user
        $isBlocked = false;
        if (auth()->check()) {
            $isBlocked = \App\Models\BlockedUser::where('user_id', auth()->id())
                ->where('blocked_user_id', $user->id)
                ->exists();
        }

        return view('employee.public_profile', compact('user', 'isBlocked', 'isBlockedByUser'));
    }


  
    public function blockUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Prevent self-block
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => "You can't block yourself 😅"]);
        }

        // Check if already blocked
        $exists = BlockedUser::where('user_id', auth()->id())
                            ->where('blocked_user_id', $user->id)
                            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => "User already blocked."]);
        }

        BlockedUser::create([
            'user_id' => auth()->id(),
            'blocked_user_id' => $user->id,
            'blocked_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'User blocked successfully.']);
    }
    public function unblockUser($id)
    {
        $user = auth()->user();

        $blocked = \App\Models\BlockedUser::where('user_id', $user->id)
            ->where('blocked_user_id', $id)
            ->first();

        if (!$blocked) {
            return response()->json(['success' => false, 'message' => 'User is not blocked.'], 404);
        }

        $blocked->delete();

        return response()->json(['success' => true]);
    }
    

    // video call method
    public function videoCall($receiverId)
    {
        $receiverUser = User::findOrFail($receiverId);
        $meId = auth()->id();

        // canonical room id: smallerId-largerId so both sides compute the same string
        $sorted = [$meId, $receiverUser->id];
        sort($sorted, SORT_NUMERIC);
        $roomId = $sorted[0] . '-' . $sorted[1];

        return view('employee.video-call', compact('receiverUser', 'roomId'));
    }




   


}
