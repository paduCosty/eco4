<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VolunteersMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailMessage;
    public $eventNname;

    /**
     * Create a new message instance.
     */
    public function __construct($mailMessage, $eventNname)
    {
        $this->mailMessage = $mailMessage;
        $this->eventNname = $eventNname;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mesaj legat de actiunea de ecologizare '. $this->eventNname.' - eco4',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.volunteers',
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
