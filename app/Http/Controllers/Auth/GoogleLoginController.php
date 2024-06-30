<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google_Client;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class GoogleLoginController extends Controller
{
        public function handleGoogleLogin(Request $request)
    {
        $idToken = $request->input('id_token');
        $clientId = config('google.client_id');

        $client = new Google_Client(['client_id' => $clientId]);

        try {
            $payload = $client->verifyIdToken($idToken);

            if ($payload) {
                $userId = $payload['sub'];
                $email = $payload['email'];
                $name = $payload['name'];

                $user  = User::where('google_id', $userId)->first();
                $admin = Admin::where('email', $email)->where('is_admin', true)->first();

                if ($user || $admin) {
                    if ($user) {
                        $user->session_id = session()->getId();
                        $user->save();
                        Auth::login($user);

                        if (session('return_to_checkout')) {
                            // Update orders with user ID
                            // You'll need to adjust this based on your database structure
                            // DB::table('orders')->where('session_id', session()->getId())->update(['user_id' => $user->id]);
                            return response()->json(['status' => 'success', 'redirect' => 'checkout']);
                        }

                        return response()->json(['status' => 'success']);
                    } elseif ($admin) {
                        Auth::guard('admin')->login($admin);
                        return response()->json(['status' => 'success_admin']);
                    }
                } else {
                    $newUser = $this->createUserAccount($userId, $email, $name);
                    Auth::login($newUser);
                    return response()->json(['status' => 'success']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid ID token'], 400);
    }

    private function createUserAccount($googleId, $email, $name)
    {
        $password = $this->generateStrongPassword();

        $user = User::create([
            'google_id' => $googleId,
            'session_id' => session()->getId(),
            'name' => $name,
            'email' => $email,
            'status' => 1,
            'password' => Hash::make($password),
            'is_verified' => 1,
        ]);

        return $user;
    }

    private function generateStrongPassword($length = 12)
    {
        return substr(md5(uniqid(rand(), true)), 0, $length);
    }
}
