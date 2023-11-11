<?php

namespace App\Http\Middleware;

use App\Jobs\SendBlockedUserEmail;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBlockedUser
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();

            // Check if the user is blocked
            if ($user->blocked) {
                // Dispatch a job to send the email notification to the user
                dispatch(new SendBlockedUserEmail($user));
                return response()->json(['error' => 'Your account is blocked. Please contact the administrator.'], 403);
            }
        }

        return $next($request);
    }
}
