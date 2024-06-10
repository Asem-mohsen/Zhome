<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class UserMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::guard('web')->check()) {
            return $next($request);
        }
        dd(Auth::guard('web')->check());
        return redirect()->route('login');
    }
}