<?php

namespace App\Listeners;

use App\Events\OrderConfirmedEvent;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmEmail
{
    public function __construct()
    {
        //
    }

    public function handle(OrderConfirmedEvent $event)
    {
        $orders = $event->orders;
        $user = $event->user;

        Mail::to($user->email)->send(new OrderConfirmationMail(
            $user->name,
            $orders,
        ));
    }
}
