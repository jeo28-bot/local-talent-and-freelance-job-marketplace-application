<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;

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

    public function indexForClient()
    {
        $clientId = auth()->id();

        $applications = \App\Models\JobApplication::with('job')
            ->whereHas('job', function ($q) use ($clientId) {
                $q->where('client_id', $clientId); // 🔥 FIXED
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.applicants', compact('applications'));
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
            // If already the same, reset back to pending
            $application->status = 'pending';
        } else {
            // Otherwise set to the new status
            $application->status = $newStatus;
        }

        $application->save();

        return redirect()->back()->with('success', 'Application status updated!');
    }
    public function destroy($id)
    {
        $application = JobApplication::findOrFail($id);
        $application->delete();

        return redirect()->back()->with('success', 'Application deleted successfully.');
    }




}
