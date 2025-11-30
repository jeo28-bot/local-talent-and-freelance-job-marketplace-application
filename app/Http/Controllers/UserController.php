<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Return the status of a user (online/offline)
     */
    public function status($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'status' => $user->status, // assuming your users table has a 'status' column
        ]);
    }

    public function keepOnline(Request $request)
    {
        $user = $request->user();

        $user->update([
            'last_seen' => now(),
            'status' => 'online', // optional
        ]);

        \Log::info("KEEP ONLINE TRIGGERED FOR USER: " . $user->id . " LAST SEEN: " . $user->last_seen);

        return response()->json(['status' => 'ok']);
    }


    public function check(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['status' => 'offline']);
        }

       $isOnline = $user->last_seen && $user->last_seen->gt(now()->subSeconds(10));


        return response()->json([
            'db_raw' => $user->status,
            'last_seen' => $user->last_seen,
            'status' => $isOnline ? 'online' : 'offline'
        ]);
    }

   public function setOffline(Request $request)
    {
        \Log::info("SET OFFLINE TRIGGERED");

        $user = $request->user();

        if ($user) {
            $user->update([
                'status' => 'offline',
            ]);

            \Log::info("USER SET OFFLINE: " . $user->id);
        }

        return response()->json(['status' => 'ok']);
    }





}
