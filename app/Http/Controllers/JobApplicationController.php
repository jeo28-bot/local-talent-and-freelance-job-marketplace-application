<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;


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

    $applications = JobApplication::with('job')
    ->whereHas('job', fn($q) => $q->where('client_id', auth()->id()))
    ->orderBy('created_at', 'desc')
    ->paginate(10);

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
