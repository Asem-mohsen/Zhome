<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use App\Traits\ApiResponse;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    use ApiResponse ;

    public function sendCode(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:user,email',
        ]);

        $email = $request->input('email');

        $code = Str::random(6);

        $user = User::where('email', $email)->first();

        if (!$user) {
            return $this->error(['message' => 'Email not found'], 'Email not found please create a new account', 404);
        }

        PasswordReset::updateOrCreate(
            ['email' => $email],
            ['code' => $code, 'expires_at' => now()->addMinutes(15)] // Code expires in 15 minutes
        );

        Mail::to($email)->send(new PasswordResetMail($code));

        return $this->success('Verification code sent to your email');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
        ]);

        $record = PasswordReset::where('email', $request->input('email'))
                                ->where('code', $request->input('code'))
                                ->where('expires_at', '>', now())
                                ->first();

        if (!$record) {
            return $this->error(['message' => 'Invalid or expired code'] ,'Invalid or expired code' , 400);
        }

        // Code is valid, proceed to password reset
        return $this->success('Code is valid, proceed to reset password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user,email',
            'code' => 'required',
            'password' => 'required|min:8',
        ]);

        $email = $request->input('email');
        $code = $request->input('code');
        $password = $request->input('password');

        $passwordReset = PasswordReset::where('email', $email)
                                        ->where('code', $code)
                                        ->where('expires_at', '>', now())
                                        ->first();

        if (!$passwordReset) {
            return $this->error(['message' => 'Invalid or expired code'] ,'Invalid or expired code' , 400);
        }

        $user = User::where('email', $email)->first();
        $user->password = Hash::make($password);
        $user->save();

        // Delete the used reset code
        $passwordReset->delete();

        return $this->success('Password reset successfully');
    }
}
