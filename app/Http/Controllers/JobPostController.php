<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller
{
    public function store(Request $request)
    {
        // ✅ validate inputs
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'job_location' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|max:100',
            'job_pay' => 'nullable|numeric',
            'salary_release' => 'nullable|string|max:50',
            'skills_required' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'full_description' => 'nullable|string',
        ]);

        // ✅ store in database
        JobPost::create([
            'client_id' => Auth::id(), // logged in user
            'job_title' => $validated['job_title'],
            'job_location' => $validated['job_location'] ?? null,
            'job_type' => $validated['job_type'] ?? null,
            'job_pay' => $validated['job_pay'] ?? null,
            'salary_release' => $validated['salary_release'] ?? null,
            'skills_required' => $validated['skills_required'] ?? null,
            'short_description' => $validated['short_description'] ?? null,
            'full_description' => $validated['full_description'] ?? null,
            'status' => 'open',
        ]);

        return redirect()->route('client.postings')->with('success', 'Job post created successfully!');
    }
   
    public function postings(Request $request)
    {
        $query = JobPost::with('client')
            ->where('client_id', Auth::id());

        if ($request->filled('q')) {
            $q = $request->q;
            $normalized = strtolower($q);

            $statusMap = [
                'active'   => 'open',
                'inactive' => 'close',
                'paused'   => 'pause',
                'pause'    => 'pause',
            ];

            $query->where(function ($subQuery) use ($q, $normalized, $statusMap) {

                $subQuery->where('job_title', 'like', "%{$q}%")
                    ->orWhere('job_type', 'like', "%{$q}%")
                    ->orWhere('job_pay', 'like', "%{$q}%")
                    ->orWhere('salary_release', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%")
                    ->orWhere('skills_required', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%");

                // 🔥 friendly status search
                if (array_key_exists($normalized, $statusMap)) {
                    $subQuery->orWhere('status', $statusMap[$normalized]);
                }
            });
        }

        if ($request->filled('location')) {
            $query->where('job_location', 'like', "%{$request->location}%");
        }

        // 🏷 Job Type filter
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        // 💰 Payment Type filter
        if ($request->filled('salary_release')) {
            $query->where('salary_release', $request->salary_release);
        }

        $posts = $query->paginate(3)->withQueryString();

        return view('client.postings', compact('posts'));
    }



    public function update(Request $request, JobPost $job)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'job_location' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|max:100',
            'job_pay' => 'nullable|numeric',
            'salary_release' => 'nullable|string|max:50',
            'skills_required' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'full_description' => 'nullable|string',
        ]);

        $job->update([
            'job_title' => $request->job_title,
            'job_location' => $request->job_location,
            'job_type' => $request->job_type,
            'job_pay' => $request->job_pay,
            'salary_release' => $request->salary_release,
            'skills_required' => $request->skills_required,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
        ]);

        return redirect()->route('client.postings')->with('success', 'Job updated successfully!');
    }

    public function destroy($id)
    {
        $post = JobPost::where('client_id', Auth::id())->findOrFail($id);

        $post->delete(); // now = archive

        return redirect()
            ->route('client.postings')
            ->with('success', 'Job post archived successfully!');
    }


    public function updateStatus(Request $request, JobPost $job)
    {
        $request->validate([
            'status' => 'required|in:open,close,pause',
        ]);

        $job->status = $request->status;
        $job->save();

        return redirect()->back()->with('success', 'Job status updated successfully!');
    }
    
    public function show($id)
    {
        $job = JobPost::findOrFail($id);
        return view('jobs', compact('job'));
    }

}
