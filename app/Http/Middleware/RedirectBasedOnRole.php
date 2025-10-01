<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is authenticated and trying to access /dashboard
        if (auth()->check() && $request->is('dashboard')) {
            $user = auth()->user();

            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'staff':
                    return redirect()->route('staff.dashboard');
                case 'patient':
                    return redirect()->route('patient.dashboard');
                default:
                    return redirect('/');
            }
        }

        return $next($request);
    }
}
