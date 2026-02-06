<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;
use App\Models\BlockedUser;
use App\Models\User;
use App\Models\Notification;
use App\Models\Announcement;
use App\Events\IncomingCallEvent;
use Carbon\Carbon;


class ClientController extends Controller
{
    public function index() {
        $announcements = Announcement::where('status', 'active')
            ->whereIn('audience', ['client', 'all']) // <-- only employee or all
            ->whereDate('release_date', '<=', Carbon::now()) // only past or today
            ->orderBy('release_date', 'desc')
            ->take(3)
            ->get();

        return view('client.index', compact('announcements'));
    }

    public function ratings() {
        return view('client.ratings');
    }

    // job post archive methods
    public function arch_jobs(Request $request)
    {
        $archivedJobs = JobPost::onlyTrashed()
            ->where('client_id', Auth::id())

            // 🔍 Main search (q)
            ->when($request->q, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('job_title', 'like', '%' . $request->q . '%')
                    ->orWhere('status', 'like', '%' . $request->q . '%')

                    // 🔢 Search by ID
                    ->orWhere('id', $request->q)

                    // 📅 Search by archived date
                    ->orWhereDate('deleted_at', $request->q);
                });
            })

            // 📍 Location filter
            ->when($request->location, function ($query) use ($request) {
                $query->where('job_location', 'like', '%' . $request->location . '%');
            })

            ->orderBy('deleted_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('client.archived.arch_jobs', compact('archivedJobs'));
    }
    public function update_archived_job(Request $request, $id)
    {
        $job = JobPost::onlyTrashed()->where('client_id', Auth::id())->findOrFail($id);

        $job->job_title = $request->job_title;
        $job->job_location = $request->job_location;
        $job->job_type = $request->job_type;
        $job->job_pay = $request->job_pay;
        $job->salary_release = $request->salary_release;
        $job->skills_required = $request->skills_required;
        $job->short_description = $request->short_description;
        $job->full_description = $request->full_description;

        $job->save();

        return redirect()->route('client.arch_jobs')->with('success', 'Archived job updated successfully!');
    }
    public function restore_archived_job($id)
    {
        $job = JobPost::onlyTrashed()->where('client_id', Auth::id())->findOrFail($id);
        $job->restore();

        return redirect()->route('client.arch_jobs')->with('success', 'Job restored!');
    }
    public function force_delete_archived_job($id)
    {
        $job = JobPost::onlyTrashed()
            ->where('client_id', Auth::id())
            ->findOrFail($id);

        $job->forceDelete();

        return redirect()
            ->route('client.arch_jobs')
            ->with('success', 'Job permanently deleted.');
    }
    // end of job post archive methods

    public function arch_applicants(Request $request)
    {
        $rawSearch = trim($request->q);
        $searchId = null;

        // 🔢 Handle formatted ID like 202575
        if ($rawSearch && preg_match('/^2025(\d+)$/', $rawSearch, $matches)) {
            $searchId = $matches[1]; // extract real ID
        } elseif (is_numeric($rawSearch)) {
            $searchId = $rawSearch;
        }

        $archivedApplicants = JobApplication::onlyTrashed()
            ->whereHas('job', function ($query) {
                $query->where('client_id', Auth::id());
            })

            // 🔢 EXACT ID SEARCH (isolated & guaranteed)
            ->when($searchId, function ($query) use ($searchId) {
                $query->where('id', $searchId);
            })

            // 🔍 TEXT SEARCH (only if NOT ID)
            ->when($rawSearch && !$searchId, function ($query) use ($rawSearch) {
                $query->where(function ($q) use ($rawSearch) {
                    $q->where('full_name', 'like', "%{$rawSearch}%")
                    ->orWhere('email', 'like', "%{$rawSearch}%")
                    ->orWhere('phone_num', 'like', "%{$rawSearch}%")
                    ->orWhere('status', 'like', "%{$rawSearch}%")
                    ->orWhereRaw("DATE(deleted_at) = ?", [$rawSearch])
                    ->orWhereHas('job', function ($job) use ($rawSearch) {
                        $job->where('job_title', 'like', "%{$rawSearch}%");
                    });
                });
            })

            ->orderBy('deleted_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('client.archived.arch_applicants', compact('archivedApplicants'));
    }


    public function restore_archived_applicants($id)
    {
        $applicant = JobApplication::onlyTrashed()
            ->whereHas('job', function ($query) {
                $query->where('client_id', Auth::id());
            })
            ->findOrFail($id);

        $applicant->restore();

        return redirect()->route('client.arch_applicants')->with('success', 'Applicant restored!');
    }
    public function force_delete_archived_applicants($id)
    {
        $applicant = JobApplication::onlyTrashed()
            ->whereHas('job', function ($query) {
                $query->where('client_id', Auth::id());
            })
            ->findOrFail($id);

        $applicant->forceDelete();

        return redirect()
            ->route('client.arch_applicants')
            ->with('success', 'Applicant permanently deleted.');
    }

    // end of applicant archive methods



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
        return view('client.ratings', compact('user', 'ratings', 'totalRatings', 'averageRating'));
    }

    public function postings()
    {
        return view('client.postings');
    }
    public function transactions()
    {
        return view('client.transactions');
    }
    public function messages()
    {
        return view('client.messages');
    }
    public function notifications()
    {
        $user = auth()->user();

        $today = Carbon::today(); // only date, no time

        $announcements = \App\Models\Announcement::where('status', 'active')
            ->where(function($q) {
                $q->where('audience', 'client')
                ->orWhere('audience', 'all');
            })
            ->whereDate('release_date', $today)  // compare only the date part
            ->orderBy('release_date', 'desc')
            ->get();

        $notifications = \App\Models\Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('client.notifications', compact('notifications', 'announcements'));
    }

    public function openNotification($id)
    {
        $note = \App\Models\Notification::findOrFail($id);

        // Mark as read
        $note->is_read = true;
        $note->save();

        // Check if this is a job application notification
        if (isset($note->data['application_id'])) {
            $applicationId = $note->data['application_id'];
            return redirect('/client/applicants?q=' . $applicationId);
        }

        // Check if this is a payout request notification
        if (isset($note->data['transaction_id'])) {
            $transactionId = $note->data['transaction_id'];
            return redirect('/client/transactions/pending?q=' . $transactionId);
        }

        // Fallback: unknown notification type
        return redirect()->route('client.notifications')
                        ->with('error', 'Invalid notification data.');
    }

    public function deleteNotification($id)
    {
        $notification = Notification::find($id); // use the correct model

        if (!$notification) {
            return redirect()->back()->with('error', 'Notification not found.');
        }

        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted.');
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

        return view('client.profile', compact('blockedUsers'));
    }
    public function applicants()
    {
        return view('client.applicants');
    }
    public function public_profile()
    {
        return view('client.public_profile');
    }
    
    public function showJob($slug)
    {
        // Find the job where slug of job_title matches
        $job = JobPost::all()->firstWhere(fn($j) => Str::slug($j->job_title) === $slug);

        if (!$job) {
            abort(404); // job not found
        }

        return view('client.jobs', compact('job'));
    }

    public function publicProfile($name)
    {
        $decodedName = urldecode($name);
        $user = \App\Models\User::where('name', $decodedName)->firstOrFail();
        $viewer = auth()->user();

        // Check if the **profile user blocked the viewer**
        $isBlockedByUser = \App\Models\BlockedUser::where('user_id', $user->id)
                            ->where('blocked_user_id', $viewer->id)
                            ->exists();

        // Check if **viewer blocked the profile user** (optional, for button hiding)
        $blockedByViewer = \App\Models\BlockedUser::where('user_id', $viewer->id)
                                ->where('blocked_user_id', $user->id)
                                ->exists();

        return view('client.public_profile', compact('user', 'isBlockedByUser', 'blockedByViewer'));
    }



    public function pendingTransactions(Request $request)
    {
        $user = auth()->user();

        $query = \App\Models\Transaction::where('client_id', $user->id)
            ->whereIn('status', ['pending', 'paid', 'requested']); // only relevant statuses

        // --- SEARCH HANDLING ---
        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%$search%")
                ->orWhere('status', 'like', "%$search%")
                ->orWhere('payment_method', 'like', "%$search%")
                ->orWhere('reference_no', 'like', "%$search%")
                ->orWhere('transaction_ref_no', 'like', "%$search%");

                // Cast numeric values
                $q->orWhereRaw("CAST(amount AS CHAR) LIKE ?", ["%$search%"]);
                $q->orWhereRaw("CAST(job_id AS CHAR) LIKE ?", ["%$search%"]);
                $q->orWhereRaw("CAST(id AS CHAR) LIKE ?", ["%$search%"]);
                $q->orWhereRaw("CAST(transaction_ref_no AS CHAR) LIKE ?", ["%$search%"]);

                // Search employee name
                $q->orWhereHas('employee', function ($emp) use ($search) {
                    $emp->where('name', 'like', "%$search%");
                });
            });
        }

        $transactions = $query->latest()->paginate(3);

        return view('client.transactions.pending', compact('transactions'));
    }



    public function completedTransactions(Request $request)
    {
        $user = auth()->user();

        $query = \App\Models\Transaction::where('client_id', $user->id)
            ->where('status', 'completed');

        // --- SEARCH HANDLING ---
        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhere('payment_method', 'like', "%$search%")
                    ->orWhere('reference_no', 'like', "%$search%")
                    ->orWhere('transaction_ref_no', 'like', "%$search%");

                // Cast numeric values
                $q->orWhereRaw("CAST(amount AS CHAR) LIKE ?", ["%$search%"]);
                $q->orWhereRaw("CAST(job_id AS CHAR) LIKE ?", ["%$search%"]);
                $q->orWhereRaw("CAST(id AS CHAR) LIKE ?", ["%$search%"]);
                $q->orWhereRaw("CAST(transaction_ref_no AS CHAR) LIKE ?", ["%$search%"]);

                // Search employee name
                $q->orWhereHas('employee', function ($emp) use ($search) {
                    $emp->where('name', 'like', "%$search%");
                });
            });
        }

        $transactions = $query->latest()->paginate(3);

        return view('client.transactions.completed', compact('transactions'));
    }

    public function destroyTransaction($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaction deleted successfully.');
    }
    public function markAsPaid(Request $request, $id)
    {
        $request->validate([
            'transaction_ref_no' => 'required|string',
        ]);

        $transaction = \App\Models\Transaction::findOrFail($id);

        // Update transaction
        $transaction->update([
            'transaction_ref_no' => $request->transaction_ref_no,
            'status' => 'completed',
            'payment_date' => now(),
        ]);

        // 🔔 Send notification to employee
        \App\Models\Notification::create([
            'user_id' => $transaction->employee_id,  // employee receives it
            'type' => 'payment_completed',
            'title' => 'Payment Completed',
            'body' => 'Your payment for "' . $transaction->job_title . '" has been completed by the client.',
            'data' => [
                'client_id' => $transaction->client_id,
                'transaction_id' => $transaction->id,
            ],
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Payment marked as completed successfully.');
    }

    public function blockUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $viewer = auth()->user();

        // Prevent self-block
        if ($user->id === $viewer->id) {
            return response()->json([
                'success' => false,
                'message' => "You can't block yourself 😅"
            ]);
        }

        // Check if already blocked
        $exists = BlockedUser::where('user_id', $viewer->id)
                              ->where('blocked_user_id', $user->id)
                              ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => "User is already blocked."
            ]);
        }

        // Block the user
        BlockedUser::create([
            'user_id' => $viewer->id,
            'blocked_user_id' => $user->id,
            'blocked_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => "User blocked successfully."
        ]);
    }
    public function unblockUser($id)
    {
        $viewer = auth()->user();

        $blocked = \App\Models\BlockedUser::where('user_id', $viewer->id)
                    ->where('blocked_user_id', $id)
                    ->first();

        if (!$blocked) {
            return response()->json([
                'success' => false,
                'message' => 'User is not blocked.'
            ], 404);
        }

        $blocked->delete();

        return response()->json([
            'success' => true,
            'message' => 'User unblocked successfully.'
        ]);
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

        return view('client.video-call', compact('receiverUser', 'roomId'));
    }

    public function startCall(Request $request)
    {
        $caller = auth()->user();
        $receiverId = $request->receiver_id;

        event(new IncomingCallEvent($receiverId, $caller));

        return response()->json(['status' => 'calling']);
    }


}

