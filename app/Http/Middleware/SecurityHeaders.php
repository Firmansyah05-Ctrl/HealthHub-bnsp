<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add security headers for production
        if (config('app.env') === 'production') {
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
            
            // HSTS header (only over HTTPS)
            if ($request->isSecure()) {
                $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
            }
            
            // Content Security Policy
            $csp = [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' unpkg.com cdn.jsdelivr.net",
                "style-src 'self' 'unsafe-inline' fonts.googleapis.com",
                "img-src 'self' data: https:",
                "font-src 'self' fonts.gstatic.com",
                "connect-src 'self'",
                "media-src 'self'",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "frame-ancestors 'none'",
                "upgrade-insecure-requests"
            ];
            
            $response->headers->set('Content-Security-Policy', implode('; ', $csp));
        }

        return $response;
    }
}