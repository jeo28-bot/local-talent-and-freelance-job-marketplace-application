<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoCallController extends Controller
{
    public function start(Request $request)
    {
        try {
            $roomName = 'room_' . Str::random(12);

            return response()->json([
                'roomName' => $roomName
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function join($roomName, Request $request)
    {
        $user = auth()->user();
        if (!$user) abort(403);

        $folder = $user->user_type === 'client' ? 'client' : 'employee';

        $callerId = $request->query('caller_id');
        $callerName = $request->query('caller_name');

        return view("$folder.video-call", compact('roomName', 'callerId', 'callerName'));
    }

    
}

