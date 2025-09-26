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

        // 📑 Pagination (3 per page just like your code)
        $posts = $query->paginate(3);

        return view('employee.postings', compact('posts'));
    }
    public function public_profile()
    {
        return view('employee.public_profile');
    }
  public function transactions()
    {
        return view('employee.transactions');
    }
  public function jobs()
    {
        return view('employee.jobs');
    }
    public function applied()
    {
        $applications = JobApplication::with(['job', 'user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10); // ✅ only 10 per page

        return view('employee.applied', compact('applications'));
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
      public function saved()
      {
          $savedJobs = auth()->user()->savedJobs()->paginate(5);

          return view('employee.saved', compact('savedJobs'));
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
