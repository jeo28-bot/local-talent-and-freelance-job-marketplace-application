<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SavedJob;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
  public function index() {
        return view('employee.index');
    }
   public function postings(Request $request)
    {
        $query = JobPost::with('client'); // eager load client for searching by name

        // 🔎 Search filter (across multiple fields)
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

        // 📍 Location filter (optional)
        if ($request->filled('location')) {
            $query->where('job_location', 'like', "%{$request->location}%");
        }

        // 🆕 Always show newest jobs first
        $query->orderBy('created_at', 'desc');

        // 📑 Pagination (3 per page)
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

        $transaction = \App\Models\Transaction::findOrFail($request->transaction_id);

        $transaction->update([
            'payment_method' => $request->payment_method,
            'reference_no' => $request->reference_no,
            'status' => 'requested',
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
                // Search inside related Job
                $q->whereHas('job', function ($jobQuery) use ($search) {
                    $jobQuery->where('job_title', 'like', "%{$search}%");
                })
                // Search inside User
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                // Search in own application columns
                ->orWhere('full_name', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhereDate('created_at', $search);
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('employee.applied', compact('applications', 'search'));
}



  public function messages()
    {
        return view('employee.messages');
    }
   public function notifications()
    {
        return view('employee.notifications');
    }
    public function profile()
    {
        return view('employee.profile');
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

        return view('employee.public_profile', compact('user'));
    }
  








   


}
