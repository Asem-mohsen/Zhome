<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Mail;

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
