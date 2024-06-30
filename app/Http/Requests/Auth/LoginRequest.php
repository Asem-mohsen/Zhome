<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Admin;
use App\Models\ShopOrders;


class LoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function handle(Login $event)
    {
        $sessionId = Session::getId();
        $userId = $event->user->id;

        $sessionCart = ShopOrders::where('session_id', $sessionId)->get();

        foreach ($sessionCart as $item) {
            $userCart = ShopOrders::firstOrNew([
                'UserID'    => $userId,
                'ProductID' => $item->ProductID,
            ]);

            $userCart->quantity = ($userCart->Quantity ?? 0) + $item->quantity;
            $userCart->save();

            $item->delete();
        }
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('email', 'password');

        $userProvider = $this->getUserProvider($credentials['email']);

        if (!$userProvider || !Auth::guard($userProvider)->attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    protected function getUserProvider(string $email): ?string
    {
        if (User::where('email', $email)->exists()) {
            return 'web';
        }

        if (Admin::where('email', $email)->exists()) {
            return 'admin';
        }

        return null;
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'Email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
