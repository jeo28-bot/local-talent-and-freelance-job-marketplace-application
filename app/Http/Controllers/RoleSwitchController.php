<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleSwitchController extends Controller
{
    public function switch(Request $request)
    {
        $request->validate([
            'role' => 'required|in:client,employee',
        ]);

        $user = auth()->user();
        $role = $request->role;

        // Admin always allowed
        if ($user->user_type === 'admin') {
            $user->update(['active_role' => $role]);
            return redirect()->route($role . '.index');
        }

        // ✅ REMOVE user_type restriction
        $user->update([
            'active_role' => $role
        ]);

        return redirect()->route($role . '.index');
    }

}
