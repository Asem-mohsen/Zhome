<?php

namespace App\Listeners;

use App\Events\ProposalOrderEvent;
use App\Mail\ProposalOrderMail;
use Illuminate\Support\Facades\Mail;

class SendProposalOrderEmail
{
    public function __construct()
    {
        //
    }

    public function handle(ProposalOrderEvent $event)
    {
        $order = $event->order;
        $user = $event->user;

        Mail::to($user->email)->send(new ProposalOrderMail(
            $user->name,
            $order,
        ));
    }
}
