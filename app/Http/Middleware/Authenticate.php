<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app/Http/Middleware/RedirectIfAuthenticated.php
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (User::check()) {
            return Response::json(['message' => 'Already authenticated, redirecting to dashboard'], 200);
        }
        return $next($request);
    }
}
