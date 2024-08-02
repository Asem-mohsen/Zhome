<?php

namespace App\Http\Middleware\AuthAPIs;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('sanctum')->user();
        
        // Check if the user is an admin
        if ($user && Admin::where('email', $user->email)->exists()) {
            return $next($request);
        }
        
        // If not an admin, return an unauthorized response
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}