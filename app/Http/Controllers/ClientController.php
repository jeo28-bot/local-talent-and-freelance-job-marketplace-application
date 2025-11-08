<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;


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
        return view('client.notifications');
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
    // EmployeeController
    public function publicProfile($name)
    {
        $decodedName = urldecode($name);
        $user = \App\Models\User::where('name', $decodedName)->firstOrFail();

        return view('client.public_profile', compact('user'));
    }

     public function pendingTransactions()
    {
        $user = auth()->user();

        // Only get non-completed transactions
        $transactions = \App\Models\Transaction::where('client_id', $user->id)
            ->whereIn('status', ['pending', 'paid', 'requested']) // 👈 Only these
            ->latest()
            ->paginate(3);

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

        $transaction->update([
            'transaction_ref_no' => $request->transaction_ref_no,
            'status' => 'completed',
            'payment_date' => now(), // ✅ sets current timestamp
        ]);

        return redirect()->back()->with('success', 'Payment marked as completed successfully.');
    }


    
}

