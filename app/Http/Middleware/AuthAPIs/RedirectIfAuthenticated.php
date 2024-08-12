<?php

namespace App\Http\Middleware\AuthAPIs;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class RedirectIfAuthenticated
{
    use ApiResponse;

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('sanctum')->user();
        // If not a user so continue the request and show him the signin page
        if (!$user) {
            return $next($request);
        }

        // If it's a user, return an unauthorized response
        return $this->error(['message' => 'The user already logged in'], 404);
    }
}