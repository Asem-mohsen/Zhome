<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName, $appName, $supportMail, $verificationLink;

    public function __construct($user)
    {
        $this->userName = $user->name;
        $this->appName = config('app.name');
        $this->supportMail = config('constants.support_email');

        $this->verificationLink = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addHour(),
            ['user' => $user->id]
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            subject: 'Email Verification Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify_email',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
