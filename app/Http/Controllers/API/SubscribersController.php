<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Subscription\CreatSubscriptionRequest;
use App\Models\Subscription;

class SubscribersController extends Controller
{
    public function index()
    {
        $subscribers = Subscription::all();

        return successResponse(compact('subscribers'), 'All Subscribers Retrieved Successfully');
    }

    public function newSubscriber(CreatSubscriptionRequest $request)
    {
        $validated = $request->validated();

        try {
            Subscription::create($validated['email']);

            return successResponse(message: 'Email Subscribed Successfully');

        } catch (\Exception $e) {
            return failureResponse(message: 'An error occured please try again later');
        }

    }
}
