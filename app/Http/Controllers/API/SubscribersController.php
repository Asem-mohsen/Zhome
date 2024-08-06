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

        return $this->data(compact('subscribers') , 'All Subscribers Retrieved Successfully');

    }

    public function newSubscriber(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $data = $request->only('email');

        try {
            Subscribers::create($data);
            return $this->success('Email Subscribed Successfully' , 200);
        } catch (\Exception $e) {
            return $this->error([] , 'An error occured');
        }

    }
}