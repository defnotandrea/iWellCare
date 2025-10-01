<?php

namespace App\Http\Middleware;

use App\Services\SecurityService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InputSanitization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sanitize all input data
        $input = $request->all();

        try {
            $sanitizedInput = SecurityService::sanitizeInput($input);
            $request->merge($sanitizedInput);
        } catch (\Exception $e) {
            // Log the security violation
            SecurityService::logSecurityEvent('Input sanitization failed', null, [
                'error' => $e->getMessage(),
                'input' => $input,
            ]);

            return response()->json([
                'error' => 'Invalid input detected',
                'message' => 'The request contains invalid data',
            ], 400);
        }

        return $next($request);
    }
}
