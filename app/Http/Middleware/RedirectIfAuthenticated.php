<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{


    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        if (Auth::guard($guard)->check()) {
            if ($guard == 'admin') {
                return route('index');
            } else {
                return redirect('/home');
            }
        }

        return $next($request);
    }
}
