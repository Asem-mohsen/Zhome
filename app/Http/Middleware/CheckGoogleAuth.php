<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckGoogleAuth
{

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/auth/google');
        }

        return $next($request);
    }
}