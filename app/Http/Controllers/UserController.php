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

        $user->update(['status' => 'online']);

        \Log::info("KEEP ONLINE TRIGGERED FOR USER: " . $user->id . " STATUS: " . $user->status);

        return response()->json(['status' => 'ok']);
    }

   public function check(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['status' => 'offline']);
        }

        return response()->json([
            'db_raw' => $user->status,
            'trimmed' => trim(strtolower($user->status)),
            'status' => trim(strtolower($user->status)) === 'online' ? 'online' : 'offline'
        ]);
    }



}
