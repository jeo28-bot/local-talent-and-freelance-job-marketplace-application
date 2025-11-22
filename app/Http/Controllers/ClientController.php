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


class ClientController extends Controller
{
    public function index() {

        return view('client.index');
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
        $notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(5); // <-- only 5 per page

        return view('client.notifications', compact('notifications'));
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





    public function profile()
    {
        return view('client.profile');
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

        // 🔎 Search filter
        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('job_title', 'like', "%$q%")
                        ->orWhere('status', 'like', "%$q%")
                        ->orWhere('id', $q) // exact match for transaction id
                        ->orWhereHas('employee', function ($employeeQuery) use ($q) {
                            $employeeQuery->where('name', 'like', "%$q%");
                        });
            });
        }

        // 🆕 Sort newest first
        $transactions = $query->latest()->paginate(3);

        return view('client.transactions.pending', compact('transactions'));
    }


    public function completedTransactions()
    {
        $user = auth()->user();

        // Only show completed transactions
        $transactions = \App\Models\Transaction::where('client_id', $user->id)
            ->where('status', 'completed')
            ->latest()
            ->paginate(3);

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
    public function videoCall()
    {
        return view('client.video-call');
    }
}

