<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIfAdminIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ('admin' && $user->is_active == 1) {
            return $next($request);
        }

        // Redirect to login with an error message if the user is not active
        return redirect()->route('notActive')->withErrors(['error' => 'Your account is not active. Please contact the administrator.']);
    }
}
