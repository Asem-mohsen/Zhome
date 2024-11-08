<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName , $userEmail ,$subject, $messageContent, $appName ;

    public function __construct($userName, $userEmail, $subject, $messageContent)
    {
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->subject = $subject;
        $this->messageContent = $messageContent;
        $this->appName = config('app.name');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact_us_email',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
