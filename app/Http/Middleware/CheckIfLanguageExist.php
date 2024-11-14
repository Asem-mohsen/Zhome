<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class CheckIfLanguageExist
{
    use ApiResponse;

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->hasHeader('accept-language')) {
            return $this->error(['accept-Language' => 'Key Missed In Headers'], 'Please send application language');
        }

        if (! in_array($request->header('accept-language'), config('services.supported-language'))) {
            return $this->error(['supported-languages' => implode(',', config('services.supported-language'))], 'This langauge is not supported');
        }
        App::setLocal($request->header('accept-language'));

        return $next($request);
    }
}
