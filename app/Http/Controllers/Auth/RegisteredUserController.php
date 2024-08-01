<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Traits\ApiResponse;

class RegisteredUserController extends Controller
{
    use ApiResponse ; 
    
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' =>     ['required', 'string', 'max:255'],
            'email' =>    ['required', 'email' , 'max:255', 'unique:user,email,except,id'],
            'password' => ['required'],
        ]);

        $user = User::create([
            'Name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        event(new Registered($user));

        Auth::guard('web')->login($user);

        return redirect(route('index', absolute: false));
    }

    
    public function apiStore(Request $request)
    {
        
        $request->validate([
            'name' =>     ['required', 'string', 'max:255'],
            'email' =>    ['required', 'email' , 'max:255', 'unique:user,email,except,id'],
            'password' => ['required'],
            'device_name' => ['required'],
            'operating_system' => ['required'],
        ]);

        $user = User::create([
            'Name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Generate a token for the user
        $user->token = "Bearer " . $user->createToken($request->device_name)->plainTextToken;
        
        // Return a JSON response with the user and token information
        $data = [
            'user' => $user,
            'token_type' => 'Bearer',
            'device_name' => $request->device_name,
            'operating_system' => $request->operating_system,
        ];
        
        return $this->data($data, 'User registered successfully');
            
        
        
    }
}