<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {

        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        return redirect()->route('login');

    }
}
