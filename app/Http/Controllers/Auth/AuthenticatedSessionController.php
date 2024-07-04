<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {

        $request->authenticate();
        $request->session()->regenerate();

        if (Auth::guard('web')->check()) {
            return redirect()->intended(route('index'));
        }

        if (Auth::guard('admin')->check()) {
            return redirect()->intended(route('Dashboard.index'));
        }

        return redirect()->route('login')->withErrors(['email' => 'Authentication error']);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $guard = Auth::guard('admin')->check() ? 'admin' : 'web';

        Auth::guard($guard)->logout();
        
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
