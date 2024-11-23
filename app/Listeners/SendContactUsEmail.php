<?php

namespace App\Listeners;

use App\Events\ContactUsEvent;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Mail;

class SendContactUsEmail
{
    public function __construct()
    {
        //
    }

    public function handle(ContactUsEvent $event)
    {
        $supportMail = config('constants.support_email');

        Mail::to($supportMail)->send(new ContactUsMail(
            $event->userName,
            $event->userEmail,
            $event->subject,
            $event->messageContent
        ));
    }
}
