<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

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


    // New method for API login
    public function apiLogin(Request $request): JsonResponse
    {
        Log::info('Login attempt', ['email' => $request->email]);

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\Admin::where('email', $credentials['email'])->first();
        if (!$user) {
            Log::warning('User not found', ['email' => $credentials['email']]);
            return response()->json(['message' => 'User not found'], 404);
        }

        if (Auth::attempt($credentials)) {
            Log::info('Login successful', ['user_id' => $user->id]);
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        Log::warning('Login failed - incorrect password', ['user_id' => $user->id]);
        return response()->json(['message' => 'Incorrect password'], 401);
    }

}