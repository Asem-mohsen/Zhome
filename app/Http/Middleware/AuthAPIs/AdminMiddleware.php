<?php

namespace App\Http\Middleware\AuthAPIs;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Traits\ApiResponse;

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
