<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function all(Request $request)
    {
        $request->user('sanctum')->tokens()->delete();

        return successResponse(message:'successfully logged out from all sessions');
    }

    public function current(Request $request)
    {
        $request->user('sanctum')->currentAccessToken()->delete();

        return successResponse(message:'successfully logged out from current session');
    }

    public function other(Request $request)
    {

        $array = explode('|', $request->header('Authorization'));
        $tokenIdArray = explode(' ', $array[0]);
        $tokenId = $tokenIdArray[1];
        $request->user('sanctum')->tokens()->where('id', $tokenId)->delete();

        return successResponse(message:'successfully logged out from other session');
    }
}
