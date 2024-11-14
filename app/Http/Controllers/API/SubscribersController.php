<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    use ApiResponse;

    public function index()
    {

        $subscribers = Subscription::all();

        return $this->data(compact('subscribers'), 'All Subscribers Retrieved Successfully');

    }

    public function newSubscriber(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $data = $request->only('email');

        try {
            Subscription::create($data);

            return $this->success('Email Subscribed Successfully', 200);
        } catch (\Exception $e) {
            return $this->error([], 'An error occured');
        }

    }
}
