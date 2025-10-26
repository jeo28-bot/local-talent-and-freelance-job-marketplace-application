<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Upload;
use App\Models\JobPost;
use App\Models\JobApplication;


class AdminController extends Controller
{
    public function index() {

        return view('admin.index');
    }
    public function applications(Request $request)
{
    $query = JobApplication::with(['user', 'job'])->orderBy('created_at', 'desc');

    if ($request->filled('search')) {
        $search = $request->input('search');

        $query->where(function ($q) use ($search) {
            // Search within JobApplication table
            $q->where('full_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone_num', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%");
        })
        // Search related user (the one who posted the job)
        ->orWhereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        })
        // Search related job
        ->orWhereHas('job', function ($q) use ($search) {
            $q->where('job_title', 'like', "%{$search}%");
        });
    }

    $applications = $query->paginate(10);

    return view('admin.applications', compact('applications'));
}




     public function jobs() {

        return view('admin.jobs');
    }
    public function showJob($title)
    {
        // decode + to spaces
        $decodedTitle = str_replace('+', ' ', $title);

        // find the job by title
        $job = JobPost::where('job_title', $decodedTitle)->first();

        if (!$job) {
            abort(404, 'Job not found.');
        }

        // pass it to the view
        return view('admin.jobs', compact('job'));
    }
    public function job_post(Request $request)
    {
        $search = $request->input('search');

        $query = \App\Models\JobPost::with('client')->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'LIKE', "%{$search}%")
                ->orWhere('job_location', 'LIKE', "%{$search}%")
                ->orWhere('job_pay', 'LIKE', "%{$search}%")
                ->orWhere('salary_release', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhereDate('created_at', $search)
                ->orWhereHas('client', function ($clientQuery) use ($search) {
                    $clientQuery->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $jobPosts = $query->paginate(10)->appends(['search' => $search]); // keep search term when paginating

        return view('admin.job_post', compact('jobPosts'));
    }


    
    public function users(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phoneNum', 'LIKE', "%{$search}%")
                ->orWhere('user_type', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.users', compact('users'));
    }
     public function profile() {

        return view('admin.profile');
    }
    public function public_profile($name)
    {
        $decodedName = urldecode($name);
        $user = \App\Models\User::where('name', $decodedName)->firstOrFail();

        return view('admin.public_profile', compact('user'));
    }
    public function edit_profile($name)
    {
        $decodedName = urldecode($name);
        $user = \App\Models\User::where('name', $decodedName)->firstOrFail();

        return view('admin.edit_profile', compact('user'));
    }

    // edit profile functions
    public function update_profile(Request $request, $name)
    {
        $user = User::where('name', $name)->firstOrFail();

         // Handle suspend toggle
        if ($request->has('toggle_suspend')) {
            // normalize status (make lowercase to avoid mismatch)
            $currentStatus = strtolower($user->status ?? 'offline');

            if ($currentStatus === 'suspended') {
                $user->status = 'offline'; // back to default
            } else {
                $user->status = 'suspended'; // suspend user
            }

            $user->save();

            return back()->with('success', 'User status updated successfully!');
        }
        
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phoneNum' => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
        ]);

        $user->name     = $request->username;
        $user->email    = $request->email;
        $user->phoneNum = $request->phoneNum;
        $user->address  = $request->address;
        $user->save();

        return back()->with('success', 'User details updated successfully!');
    }
    public function update_profile_picture(Request $request, $name)
    {
        $user = User::where('name', $name)->firstOrFail();

        $request->validate([
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('profile_pic')) {
            // store the uploaded image
            $path = $request->file('profile_pic')->store('profile_pics', 'public');

            // delete old one if it exists
            if ($user->profile_pic && \Storage::disk('public')->exists($user->profile_pic)) {
                \Storage::disk('public')->delete($user->profile_pic);
            }

            // update path in DB
            $user->profile_pic = $path;
            $user->save();
        }

        return back()->with('success', 'Profile picture updated successfully!');
    }
    public function update_about(Request $request, $name)
    {
        $user = User::where('name', $name)->firstOrFail();

        $request->validate([
            'about_details' => 'nullable|string|max:1000',
        ]);

        $user->about_details = $request->input('about_details');
        $user->save();

        return back()->with('success', 'About details updated successfully!');
    }
    public function update_skills(Request $request, $name)
    {
        $request->validate([
            'skills' => 'nullable|string|max:5000',
        ]);

        $user = User::where('name', $name)->firstOrFail();
        $user->skills = $request->skills;
        $user->save();

        return back()->with('success', 'Skills updated successfully!');
    }
    public function upload_files(Request $request, $name)
    {
        $request->validate([
            'files.*'  => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = User::where('name', $name)->firstOrFail();

        // General files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('uploads/files', 'public');
                $user->uploads()->create([
                    'type'           => 'file',
                    'path'           => $path,
                    'original_name'  => $file->getClientOriginalName(),
                ]);
            }
        }

        // Image files
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/images', 'public');
                $user->uploads()->create([
                    'type'           => 'image',
                    'path'           => $path,
                    'original_name'  => $image->getClientOriginalName(),
                ]);
            }
        }

        return back()->with('success', 'Files uploaded successfully!');
    }
    public function destroy_upload($name, $id)
    {
        $user = User::where('name', $name)->firstOrFail();
        $upload = Upload::where('id', $id)
                        ->where('user_id', $user->id)
                        ->firstOrFail();

        // Delete file from storage (make sure the path includes 'public/')
        \Storage::disk('public')->delete($upload->path);

        // Delete record
        $upload->delete();

        return back()->with('success', 'File deleted successfully.');
    }
    public function delete_user($name)
    {
        $user = User::where('name', urldecode($name))->firstOrFail();
        $user->delete();

        // redirect to admin users listing
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }
    public function destroyJobPost($id)
    {
        $job = JobPost::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.job_post')->with('success', 'Job post deleted successfully!');
    }







    // export applications to CSV
    public function exportApplications(Request $request)
    {
        $query = JobApplication::with(['user', 'job'])->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone_num', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
            })
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('job', function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%");
            });
        }

        $applications = $query->get(); // 👈 no pagination — export all filtered

        $response = new StreamedResponse(function () use ($applications) {
            $handle = fopen('php://output', 'w');

            // CSV Header
            fputcsv($handle, [
                '#',
                'Client Name',
                'Job Title',
                'Full Name',
                'Email',
                'Phone Number',
                'Message',
                'Status',
                'Date Created',
            ]);

            // CSV Data Rows
            foreach ($applications as $index => $app) {
                fputcsv($handle, [
                    $index + 1,
                    optional($app->user)->name ?? 'Unknown User (ID: ' . $app->user_id . ')',
                    optional($app->job)->job_title ?? 'Unknown Job (ID: ' . $app->job_id . ')',
                    $app->full_name,
                    $app->email,
                    $app->phone_num,
                    $app->message ?? 'No message provided',
                    $app->status,
                    $app->created_at->format('M d, Y'),
                ]);
            }

            fclose($handle);
        });

        $filename = 'job_applications_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename={$filename}");

        return $response;
    }

    // export job posts to CSV
    public function exportJobPosts(Request $request)
    {
        $search = $request->input('search');

        $query = JobPost::with('client')->orderBy('created_at', 'desc');

        // 🔍 Apply search filters if search is provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'LIKE', "%{$search}%")
                ->orWhere('job_location', 'LIKE', "%{$search}%")
                ->orWhere('job_pay', 'LIKE', "%{$search}%")
                ->orWhere('salary_release', 'LIKE', "%{$search}%")
                ->orWhere('job_type', 'LIKE', "%{$search}%")
                ->orWhere('skills_required', 'LIKE', "%{$search}%")
                ->orWhere('short_description', 'LIKE', "%{$search}%")
                ->orWhere('full_description', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhereDate('created_at', $search)
                ->orWhereHas('client', function ($clientQuery) use ($search) {
                    $clientQuery->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        // ✅ Get all matching results (not paginated)
        $jobPosts = $query->get();

        $response = new StreamedResponse(function () use ($jobPosts) {
            $handle = fopen('php://output', 'w');

            // 🧾 CSV Header
            fputcsv($handle, [
                'Job Title',
                'Client Name',
                'Location',
                'Pay',
                'Salary Release',
                'Job Type',
                'Skills Required',
                'Short Description',
                'Full Description',
                'Status',
                'Created At',
                'Updated At'
            ]);

            // 🧩 Write data rows
            foreach ($jobPosts as $job) {
                fputcsv($handle, [
                    $job->job_title,
                    $job->client->name ?? 'N/A',
                    $job->job_location,
                    $job->job_pay,
                    $job->salary_release,
                    $job->job_type,
                    $job->skills_required,
                    $job->short_description,
                    $job->full_description,
                    $job->status,
                    $job->created_at ? $job->created_at->format('Y-m-d H:i:s') : '',
                    $job->updated_at ? $job->updated_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($handle);
        });

        // 🧠 Filename logic
        $filename = $search
            ? 'filtered_job_posts_' . now()->format('Y-m-d_H-i-s') . '.csv'
            : 'all_job_posts_' . now()->format('Y-m-d_H-i-s') . '.csv';

        // 🧾 Headers
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename={$filename}");

        return $response;
    }


    // export users to CSV
    public function export(Request $request): StreamedResponse
    {
        $search = $request->input('search');

        // Build query same as your index logic
        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phoneNum', 'LIKE', "%{$search}%")
                ->orWhere('user_type', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }

        // fetch all results (no pagination)
        $users = $query->get(['id',
        'name',
        'email',
        'phoneNum',
        'address',
        'about_details',
        'skills',
        'user_type',
        'status',
        'created_at',]);

        // Stream CSV response
        $response = new StreamedResponse(function () use ($users) {
            $handle = fopen('php://output', 'w');

            // CSV headers
            fputcsv($handle, ['ID',
            'Name',
            'Email',
            'Phone Number',
            'Address',
            'About Details',
            'Skills',
            'User Type',
            'Status',
            'Created At',]);

            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phoneNum,
                    $user->address,
                    $user->about_details,
                    $user->skills,
                    $user->user_type,
                    $user->status,
                    $user->created_at,
                ]);
            }

            fclose($handle);
        });

        $filename = $search ? "users_filtered_{$search}.csv" : "users_all.csv";

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename={$filename}");

        return $response;
    }
}
