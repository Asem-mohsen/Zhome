<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected function redirectTo()
    {
        if (Auth::guard('admin')->check()) {
            return '/admin/dashboard';
        }

        return '/home';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    // public function login(Request $request)
    // {
    //     $validatedData = $this->validateLogin($request);

    //     if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
    //         $this->fireLockoutEvent($request);
    //         return $this->sendLockoutResponse($request);
    //     }

    //     // Attempt to login as user
    //     if ($this->attemptLogin($request)) {
    //         return $this->sendLoginResponse($request);
    //     }

    //     $this->incrementLoginAttempts($request);
    //     return $this->sendFailedLoginResponse($request);
    // }

    // protected function attemptLogin(Request $request)
    // {
    //     $credentials = $this->credentials($request);

    //     // Attempt to find the user by username
    //     $admin = Admin::where('Email', $request->email)->first();

    //     // Check if the user exists
    //     if (!$admin) {
    //         return response()->json(['error' => 'Invalid credentials'], 401);
    //     }

    //     // Attempt to login as a user
    //     if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
    //         return true;
    //     }
        
    //     if (Hash::check($request->password, $admin->Password)) {
    //         Auth::guard('admin')->login($admin);
    //         return true;
    //     }

    //     return false;
    // }
    public function login(Request $request)
    {
        $validatedData = $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // Attempt to find the user by username
        $admin = Admin::where('Email', $request->email)->first();

        // Check if the user exists
        if ($admin && Hash::check($request->password, $admin->Password)) {
            if (Auth::guard('web')->attempt($this->credentials($request), $request->filled('remember'))) {
                return $this->sendLoginResponse($request);
            } else {
                Auth::guard('admin')->login($admin);
                // dd($this->sendLoginResponse($request));
                return $this->sendLoginResponse($request);
            }
        } else {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        if (Auth::guard('admin')->check()) {
            return redirect()->route('index');
        }

        return redirect()->intended($this->redirectPath());
    }
}


// HERE all things are true it send true the admin is really authenticated 
// the problem comes from the next route when it goes to the route index it find the middleware auth.admin