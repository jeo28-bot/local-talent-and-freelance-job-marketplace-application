<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;

class PublicController extends Controller
{
   public function publicPostings(Request $request)
    {
        $query = JobPost::with('client')->orderBy('created_at', 'desc');

        // Search filter
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('job_title', 'like', "%$q%")
                    ->orWhere('job_type', 'like', "%$q%")
                    ->orWhere('job_pay', 'like', "%$q%")
                    ->orWhere('salary_release', 'like', "%$q%")
                    ->orWhere('short_description', 'like', "%$q%")
                    ->orWhere('skills_required', 'like', "%$q%");
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('job_location', 'like', "%{$request->location}%");
        }

        $posts = $query->paginate(3);

        return view('public_job_postings', compact('posts'));
    }

}
