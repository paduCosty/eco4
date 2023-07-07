<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailToPartner extends Mailable
{
    use Queueable, SerializesModels;

    public $partnerName;
    public $dueDate;
    public $address;
    public $coordinatorName;
    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct($partnerName, $dueDate, $address, $coordinatorName, $url)
    {
        $this->partnerName = $partnerName;
        $this->dueDate = $dueDate;
        $this->address = $address;
        $this->coordinatorName = $coordinatorName;
        $this->url = $url;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'O noua actiune de ecologizare eco4 a fost propusa',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.partner_mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
