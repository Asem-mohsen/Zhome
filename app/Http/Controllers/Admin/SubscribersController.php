<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    public function index()
    {
        $subscribers = Subscription::all();

        return view('Admin.Subscribers.index', compact('subscribers'));
    }

    public function newSubscriber(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $data = $request->only('email');

        try {
            Subscription::create($data);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }

    }
}
