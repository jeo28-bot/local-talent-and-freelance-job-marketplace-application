<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\JobPostController;



class JobApplicationController extends Controller
{
    public function store(Request $request, $jobId)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'phone_num' => 'nullable|string|max:20',
            'message'   => 'nullable|string',
        ]);

        JobApplication::create([
            'job_id'    => $jobId,
            'user_id'   => auth()->check() ? auth()->id() : null, // ✅ attaches logged in user
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'phone_num' => $data['phone_num'] ?? null,
            'message'   => $data['message'] ?? null,
            'status'    => 'pending',
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }

    public function indexForClient(Request $request)
    {
        $clientId = auth()->id();
        $search = $request->input('q'); // search query

        $applications = \App\Models\JobApplication::with(['job', 'user'])
            ->whereHas('job', function ($q) use ($clientId) {
                $q->where('client_id', $clientId);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    // 🔍 Search by applicant name (from users table)
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    })
                    // 🔍 OR search by full name (from job_applications table)
                    ->orWhere('full_name', 'like', "%{$search}%")
                    // 🔍 OR search by job title (from job_posts table)
                    ->orWhereHas('job', function ($jobQuery) use ($search) {
                        $jobQuery->where('job_title', 'like', "%{$search}%");
                    })
                    // 🔍 OR search by status
                    ->orWhere('status', 'like', "%{$search}%")
                    // 🔍 OR search by created_at date (like "2025-11-01")
                    ->orWhereDate('created_at', $search);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.applicants', compact('applications', 'search'));
    }



    public function job()
    {
        return $this->belongsTo(\App\Models\JobPost::class, 'job_id');
    }
    public function updateStatus(Request $request, $id)
    {
        $application = JobApplication::findOrFail($id);
        $newStatus = $request->status;

        // Toggle logic
        if ($application->status === $newStatus) {
            $application->status = 'pending';
        } else {
            $application->status = $newStatus;
        }

        $application->save();

        // ✅ Handle transaction logic
        $job = $application->job;

        if ($application->status === 'accepted') {
            // Create transaction if not exists
            $exists = \App\Models\Transaction::where('job_id', $job->id)
                ->where('employee_id', $application->user_id)
                ->first();

            if (!$exists) {
                \App\Models\Transaction::create([
                    'job_id' => $job->id,
                    'employee_id' => $application->user_id,
                    'client_id' => $job->client_id,
                    'job_title' => $job->job_title ?? 'Untitled Job',
                    'amount' => $job->job_pay ?? 0,
                    'status' => 'pending',
                ]);
            }
        } else {
            // ❌ If status is changed from accepted → remove transaction
            \App\Models\Transaction::where('job_id', $job->id)
                ->where('employee_id', $application->user_id)
                ->delete();
        }

        return redirect()->back()->with('success', 'Application status updated!');
    }
    

    public function destroy($id)
    {
        $application = JobApplication::findOrFail($id);
        $application->delete();

        return redirect()->back()->with('success', 'Application deleted successfully.');
    }

    public function cancel($id)
    {
        $application = JobApplication::where('id', $id)
            ->where('user_id', Auth::id()) // security: only cancel own application
            ->firstOrFail();

        $application->update([
            'status' => 'cancelled'
        ]);

        return redirect()->back()->with('success', 'Application cancelled successfully.');
    }
    
 
}
