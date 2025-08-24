<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType

{
    public function handle(Request $request, Closure $next, $type)
    {
        if (auth()->check() && auth()->user()->user_type === $type) {
            return $next($request);
        }

        abort(403, 'Unauthorized access'); // or redirect('/home')
    }
}