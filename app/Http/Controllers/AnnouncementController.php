<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Support\Carbon;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('status', 'active')
            ->where('release_date', '<=', Carbon::now())
            ->orderBy('release_date', 'desc')
            ->take(3)
            ->get();

        return view('index', compact('announcements'));
    }

}
