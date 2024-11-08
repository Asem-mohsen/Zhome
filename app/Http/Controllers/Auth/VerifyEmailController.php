<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\VerificationCodeRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    use ApiResponse ;

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

    public function send(Request $request){

        $user = $request->user('sanctum');
        $token = $request->header('Authorization');
        $verificationCode = rand(10000 , 99999);

        $user->verification_code = $verificationCode;
        $user->save();

        // send email step
        $user->token = $token;
        return $this->data(compact('user'));

    }

    public function verifyEmailLink(Request $request, $userId)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired verification link.');
        }

        $user = User::findOrFail($userId);
        $user->update(['email_verified_at' => now()]);

        return $this->success('Your email has been verified successfully');
    }

    public function verify(VerificationCodeRequest $request){
        $user = $request->user('sanctum');
        $token = $request->header('Authorization');

        if($user->verification_code == $request->verification_code){
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->save;
            $user->token = $token;
            return $this->data(compact('user') , 'Email verified successfully');
        }else{
            return $this->error(['Verification code' => 'wrong']);
        }
    }
}
