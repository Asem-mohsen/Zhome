<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProposalOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName , $supportMail , $appName , $order;

    public function __construct($userName, $order)
    {
        $this->userName = $userName;
        $this->order = $order;
        $this->appName = config('app.name');
        $this->supportMail = config('constants.support_email');
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            subject: 'Proposal Order',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.proposal_order_email',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
