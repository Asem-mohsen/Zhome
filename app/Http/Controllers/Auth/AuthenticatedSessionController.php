<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Requests\API\Auth\{ LoginRequest };

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
            return redirect()->intended(route('Dashboard.index'));
        }

        return redirect()->route('login')->withErrors(['email' => 'Authentication error']);
    }

    public function destroy(Request $request): RedirectResponse
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // New method for API login
    public function apiLogin(LoginRequest $request)
    {
        $validated = $request->validated();

        $email = $validated['email'];
        $password = $validated['password'];
        $deviceName = $validated['device_name'];

        $userData = User::where('email', $email)->first();

        if ($userData->is_admin != 1 && $userData->role->role == 'user') {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::guard('sanctum')->user();
                $accessToken = $user->createToken($deviceName)->plainTextToken;

                return successResponse(['user' => $user, 'token' => $accessToken] , 'logged In successfully');
            }
        } elseif ($userData->is_admin == 1 && $userData->role->role != 'user') {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::guard('sanctum')->user();
                $accessToken = $user->createToken($deviceName)->plainTextToken;

                return successResponse(['admin' => $user, 'token' => $accessToken] , 'logged In successfully');
            }
        }

        return failureResponse('Please make sure that your data is valid' , code:401);
    }
}
