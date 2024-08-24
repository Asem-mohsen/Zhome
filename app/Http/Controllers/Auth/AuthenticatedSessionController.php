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
use App\Traits\ApiResponse;
use App\Models\User;
use App\Models\Admin;

class AuthenticatedSessionController extends Controller
{
    use ApiResponse;

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
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email'      => 'required|email|max:255',
            'password'   => 'required',
            'device_name'=> 'required',
        ]);
        // $user  = User::where('email' , $request->email)->first();
        // $admin = Admin::where('email' , $request->email)->first();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('sanctum')->user();
            $accessToken = $user->createToken($request->device_name)->plainTextToken;
            return response(['user' => $user, 'token' => $accessToken]);
        }

        // If user authentication fails, try admin authentication
        $admin = Admin::where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Manually authenticate the admin
            Auth::guard('admin')->login($admin);
            $accessToken = $admin->createToken($request->device_name)->plainTextToken;
            return response(['admin' => $admin, 'token' => $accessToken]);
        }

        // If both checks fail, return an error response
        return $this->error(['message' => 'Authentication failed'], 'Please make sure that your data is valid' , 401);
    }

    public function Currentuser(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        return $this->data(['user' => $user] , 'User Retrived Successfully');
    }
}
