<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->type === 2) {
            // Check if the user is an admin (type 2).
            return $next($request);
        }

        return response()->json(['error' => 'Access denied. Only admin can perform this action.'], 403);
    }
}
