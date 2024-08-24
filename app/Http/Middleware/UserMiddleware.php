<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class UserMiddleware
{
    use ApiResponse ;
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::guard('sanctum')->check()) {
            return $next($request);
        }
        return $this->error(['message' => "Plase login first"],'LogIn first' , 401);
    }
}
