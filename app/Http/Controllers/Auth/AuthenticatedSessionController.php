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
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
    public function apiLogin(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        // Check for User authentication
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        // Check for Admin authentication
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('auth-token')->plainTextToken;
            return response()->json([
                'user' => $admin,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        // If both checks fail, return an error response
        return response()->json(['message' => 'Authentication failed'], 401);
    }

}