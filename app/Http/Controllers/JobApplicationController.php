<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\JobPostController;
use App\Models\Notification;



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

        // 🔥 Get the job first
        $job = \App\Models\JobPost::findOrFail($jobId);
        $employee = auth()->user(); // the one applying
        $employerId = $job->client_id; // the client who owns the job

        // Create the job application
        $application = JobApplication::create([
            'job_id'    => $jobId,
            'user_id'   => $employee->id ?? null,
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'phone_num' => $data['phone_num'] ?? null,
            'message'   => $data['message'] ?? null,
            'status'    => 'pending',
        ]);

        // Create a single notification with proper array in `data`
        \App\Models\Notification::create([
            'user_id' => $employerId, // who receives it
            'type'    => 'job_application',
            'title'   => 'New Job Application',
            'body'    => "{$employee->name} applied for your job: {$job->job_title}",
            'data'    => [
                'job_id' => $job->id,
                'applicant_id' => $employee->id,
                'application_id' => $application->id,
            ],
            'is_read' => false,
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }




    public function indexForClient(Request $request)
    {
        $clientId = auth()->id();
        $search = $request->input('q');

        $applications = \App\Models\JobApplication::with(['job', 'user'])
            ->whereHas('job', function ($q) use ($clientId) {
                $q->where('client_id', $clientId);
            })
            ->when($search, function ($query, $search) {

                // Check if search is formatted like 2025{id}
                $numericId = null;
                if (preg_match('/^2025(\d+)$/', $search, $matches)) {
                    $numericId = $matches[1];
                }

                $query->where(function ($q) use ($search, $numericId) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhereHas('job', function ($jobQuery) use ($search) {
                        $jobQuery->where('job_title', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereDate('created_at', $search);

                    // 🔍 Search by application ID (raw or prefixed with 2025)
                    if ($numericId) {
                        $q->orWhere('id', $numericId);
                    } elseif (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
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

        if ($application->status === $newStatus) {
            $application->status = 'pending';
        } else {
            $application->status = $newStatus;
        }

        $application->save();

        $job = $application->job;

        // ------------------------------------
        // 🔥 CREATE NOTIFICATION FOR EMPLOYEE
        // ------------------------------------
        $statusMessage = match($application->status) {
            'accepted' => "Client accepted your application for {$job->job_title}.",
            'rejected' => "Client rejected your application for {$job->job_title}.",
            'pending'  => "Client moved your application for {$job->job_title} to pending.",
            default     => null
        };

        if ($statusMessage) {
            Notification::create([
                'user_id' => $application->user_id,
                'type' => 'job_status',
                'title' => 'Job Application Update',
                'body' => $statusMessage,
                'is_read' => false,
                'data' => [
                    'client_id' => $job->client_id,
                    'application_id' => $application->id, // <- needed!
                ]
            ]);
        }

        // ---------------------------------------------------------------
        // existing transaction logic...
        // ---------------------------------------------------------------

        if ($application->status === 'accepted') {
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
