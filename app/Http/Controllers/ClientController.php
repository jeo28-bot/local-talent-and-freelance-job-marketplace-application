<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost; 
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index() {

        return view('client.index');
    }
    public function postings()
    {
        return view('client.postings');
    }
    public function transactions()
    {
        return view('client.transactions');
    }
    public function messages()
    {
        return view('client.messages');
    }
    public function notifications()
    {
        return view('client.notifications');
    }
    public function profile()
    {
        return view('client.profile');
    }
    public function applicants()
    {
        return view('client.applicants');
    }
    public function public_profile()
    {
        return view('client.public_profile');
    }
    
    public function showJob($slug)
    {
        // Find the job where slug of job_title matches
        $job = JobPost::all()->firstWhere(fn($j) => Str::slug($j->job_title) === $slug);

        if (!$job) {
            abort(404); // job not found
        }

        return view('client.jobs', compact('job'));
    }
    
}

