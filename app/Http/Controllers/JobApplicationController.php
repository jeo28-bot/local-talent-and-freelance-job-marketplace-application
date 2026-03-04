<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\JobPostController;
use App\Models\Notification;
use App\Models\JobPost;
use App\Models\Message;



class JobApplicationController extends Controller
{
    public function store(Request $request, $jobId)
    {
        // 🔥 Get the job first
        $job = \App\Models\JobPost::findOrFail($jobId);
        $employee = auth()->user();
        $employerId = $job->client_id;

        // ✅ Base validation
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'phone_num' => 'nullable|string|max:20',
            'message'   => 'nullable|string',
        ]);

        $uploadedDocuments = [];

        // ✅ Handle required documents if the job has any
        if (!empty($job->required_documents)) {

            foreach ($job->required_documents as $doc) {

                // Make sure file exists
                if (!$request->hasFile("required_documents.$doc")) {
                    return back()
                        ->withErrors(["required_documents.$doc" => ucfirst($doc) . " is required."])
                        ->withInput();
                }

                $file = $request->file("required_documents.$doc");

                // Generate unique filename
                $filename = time() . '_' . $employee->id . '_' . $doc . '.' . $file->getClientOriginalExtension();

                // Store in storage/app/public/job_applications
                $path = $file->storeAs('job_applications', $filename, 'public');

                $uploadedDocuments[$doc] = $path;
            }
        }

        // ✅ Create the job application
        $application = JobApplication::create([
            'job_id'    => $jobId,
            'user_id'   => $employee->id ?? null,
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'phone_num' => $data['phone_num'] ?? null,
            'message'   => $data['message'] ?? null,
            'status'    => 'pending',
            'required_documents' => $uploadedDocuments, // 🔥 save files here
        ]);

        // ✅ Create notification
        \App\Models\Notification::create([
            'user_id' => $employerId,
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

        // Paginated applications for table view
        $applications = \App\Models\JobApplication::with(['job', 'user'])
            ->whereHas('job', function ($q) use ($clientId) {
                $q->where('client_id', $clientId);
            })
            ->when($search, function ($query, $search) {
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

                    if ($numericId) {
                        $q->orWhere('id', $numericId);
                    } elseif (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // All applications for list view (no pagination)
        $allApplications = \App\Models\JobApplication::with(['job', 'user'])
            ->whereHas('job', function ($q) use ($clientId) {
                $q->where('client_id', $clientId);
            })
            ->when($search, function ($query, $search) {
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

                    if ($numericId) {
                        $q->orWhere('id', $numericId);
                    } elseif (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->get(); // <-- all results

        return view('client.applicants', compact('applications', 'allApplications', 'search'));
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
            default    => null
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
                    'application_id' => $application->id,
                ]
            ]);
        }

        // ------------------------------------------------
        // 🔥 SEND CHAT MESSAGE WHEN REJECTED (NEW)
        // ------------------------------------------------
        if ($application->status === 'rejected' && $request->filled('message')) {

            Message::create([
                'sender_id'   => auth()->id(),               // client
                'receiver_id' => $application->user_id,     // employee
                'content'     => $request->message,
                'file'        => null,
                'file_type'   => null,
                'is_vc'       => null,
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
        $application->delete(); // ← soft delete now

        return redirect()->back()->with('success', 'Application archived successfully.');
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
