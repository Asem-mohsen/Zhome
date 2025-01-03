<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerificationCodeRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    use ApiResponse;

    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }

    public function send(Request $request)
    {

        $user = $request->user('sanctum');
        $token = $request->header('Authorization');
        $verificationCode = rand(10000, 99999);

        $user->verification_code = $verificationCode;
        $user->save();

        // send email step
        $user->token = $token;

        return successResponse(compact('user') , 'email verification sent');
    }

    public function verifyEmailLink(Request $request, $userId)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired verification link.');
        }
    
        $user = User::findOrFail($userId);
        $user->update(['email_verified_at' => now()]);

        $url = config('app.frontend_url');

        return redirect($url.'/email-verified'); 
    }

    public function verify(VerificationCodeRequest $request)
    {
        $user = $request->user('sanctum');
        $token = $request->header('Authorization');

        if ($user->verification_code == $request->verification_code) {
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->save;
            $user->token = $token;

            return successResponse(compact('user'), 'Email verified successfully');
        } else {
            return failureResponse('verification link has expired');
        }
    }
}
