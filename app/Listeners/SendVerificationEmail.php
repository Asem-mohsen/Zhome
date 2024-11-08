<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Mail;
use App\Events\UserRegisteredEvent;

class SendVerificationEmail
{

    public function __construct()
    {
        //
    }

    public function handle(UserRegisteredEvent $event)
    {
        $user = $event->user;

        Mail::to($user->email)->send(new EmailVerificationMail($user));
    }
}
