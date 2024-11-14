<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Middleware\StartSession as BaseStartSession;

class StartSession extends BaseStartSession
{
    public function handle($request, Closure $next)
    {
        return parent::handle($request, $next);
    }
}
