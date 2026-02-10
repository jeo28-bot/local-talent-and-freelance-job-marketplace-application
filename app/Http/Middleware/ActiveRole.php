<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            abort(403);
        }

        // Admin can access anything
        if (auth()->user()->user_type === 'admin') {
            return $next($request);
        }

        $user = auth()->user();

        // If active_role is null, allow access to the dashboard matching user_type
        if ($user->active_role === null && $user->user_type === $role) {
            return $next($request);
        }

        // Otherwise, normal check
        if ($user->active_role !== $role) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }

}