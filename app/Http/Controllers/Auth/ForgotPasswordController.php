<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\{ ResetPasswordRequest ,SendCodeRequest , VerifyCodeRequest};
use App\Mail\PasswordResetMail;
use App\Models\{ User , PasswordReset};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendCode(SendCodeRequest $request)
    {
        $validated = $request->validated();

        $email = $validated['email'];

        $code = Str::random(6);

        $user = User::where('email', $email)->first();

        if (! $user) {
            return failureResponse(message:'Email not found please create a new account' , code: 404);
        }

        PasswordReset::updateOrCreate(
            ['email' => $email],
            ['code' => $code, 'expires_at' => now()->addMinutes(15)] // Code expires in 15 minutes
        );

        Mail::to($email)->send(new PasswordResetMail($code));

        return successResponse(message:'Verification code sent to your email');
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        $validated = $request->validated();

        $record = PasswordReset::where('email', $validated['email'])
            ->where('code', $validated['code'])
            ->where('expires_at', '>', now())
            ->first();

        if (! $record) {
            return failureResponse(message:'Invalid or expired code' , code: 400);
        }

        return successResponse(message:'Code is valid, proceed to reset password');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $validated = $request->validated();

        $email = $validated['email'];
        $code = $validated['code'];
        $password = $validated['password'];

        $passwordReset = PasswordReset::where('email', $email)
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->first();

        if (! $passwordReset) {
            return failureResponse(message:'Invalid or expired code' , code: 400);
        }

        $user = User::where('email', $email)->first();
        $user->password = Hash::make($password);
        $user->save();

        $passwordReset->delete();

        return successResponse(message:'Password reset successfully');
    }
}
