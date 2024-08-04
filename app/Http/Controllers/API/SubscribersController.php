<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscribers;
use App\Traits\ApiResponse;

class SubscribersController extends Controller
{
    use ApiResponse;
    
    public function index(){

        $subscribers = Subscribers::all();
        return view('Admin.Subscribers.index' , compact('subscribers'));

    }

    public function newSubscriber(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $data = $request->only('email');

        try {
            Subscribers::create($data);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }

    }
}
