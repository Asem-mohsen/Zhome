<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use ApiResponse;

    public function all(Request $request)
    {
        $request->user('sanctum')->tokens()->delete();

        return $this->success('successfully logged out from all sessions');
    }

    public function current(Request $request)
    {
        // Revoke the token that was used to authenticate the current request...
        $request->user('sanctum')->currentAccessToken()->delete();

        return $this->success('successfully logged out from current session');
    }

    public function other(Request $request)
    {

        $array = explode('|', $request->header('Authorization'));
        $tokenIdArray = explode(' ', $array[0]);
        $tokenId = $tokenIdArray[1];
        $request->user('sanctum')->tokens()->where('id', $tokenId)->delete();

        return $this->success('successfully logged out from the other sessions');
    }
}
