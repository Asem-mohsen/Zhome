<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
        $order = $event->order;
        $user = $event->user;

        Mail::to($user->email)->send(new OrderConfirmationMail(
            $user->name,
            $order,
        ));
    }
}
