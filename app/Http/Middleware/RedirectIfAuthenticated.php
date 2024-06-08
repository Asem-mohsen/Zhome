<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class RedirectIfAuthenticated
{


    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        if (Auth::guard($guard)->check()) {
            if ($guard == 'admin') {
                return redirect()->route('index');
            } else {
                return redirect('/login');
            }
        }

        return $next($request);
    }
}