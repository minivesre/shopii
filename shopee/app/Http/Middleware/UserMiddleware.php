<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the authenticated user is a regular user
        if (Auth::check() && Auth::user()->isUser()) {
            return $next($request);
        }

        // Redirect or perform some other action for non-user roles
        return redirect('/');
    }
}