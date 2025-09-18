<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SavedJob;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
  public function index() {
        return view('employee.index');
    }
   public function postings()
    {
        $posts = JobPost::paginate(3); 
        return view('employee.postings', compact('posts'));
    }
  public function transactions()
    {
        return view('employee.transactions');
    }
  public function jobs()
    {
        return view('employee.jobs');
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
        $job = JobPost::whereRaw("REPLACE(LOWER(job_title), ' ', '-') = ?", [$slug])->firstOrFail();
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

   

}
