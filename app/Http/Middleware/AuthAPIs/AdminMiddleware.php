<?php

namespace App\Http\Middleware\AuthAPIs;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    use ApiResponse;

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('sanctum')->user();

        if ($user && $user->is_admin == 1 && $user->role->role !== 'user') {
            return $next($request);
        }

        return $this->error(['message' => 'Unauthorized'], 403);
    }
}
