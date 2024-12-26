<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegisteredEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    use ApiResponse;

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:user,email,except,id'],
            'password' => ['required'],
        ]);

        $user = User::create([
            'Name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        event(new UserRegisteredEvent($user));

        Auth::guard('web')->login($user);

        return redirect(route('index', absolute: false));
    }

    public function apiStore(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => 1,
        ]);

        // Generate a token for the user
        $token = $user->createToken($validated['device_name'])->plainTextToken;

        $verificationEmailStatus = 'not sent';
        if (config('auth.verification.enabled', true)) {
            event(new UserRegisteredEvent($user));
            $verificationEmailStatus = 'sent';
        }

        // Return a JSON response with the user and token information
        $data = [
            'user' => $user,
            'token_type' => 'Bearer',
            'token' => $token,
            'device_name' => $validated['device_name'],
            'operating_system' => $validated['operating_system'],
            'verification_email' => $verificationEmailStatus,
        ];
        return successResponse($data, 'User registered successfully');
    }
}
