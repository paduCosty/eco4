<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventDateChangePartnerEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $coordinatorName;
    public $eventName;
    public $dueData;
    public $coordinatorPhone;

    /**
     * Create a new message instance.
     */
    public function __construct($coordinatorName, $eventName, $dueData, $coordinatorPhone)
    {
        $this->coordinatorName = $coordinatorName;
        $this->eventName = $eventName;
        $this->dueData = $dueData;
        $this->coordinatorPhone = $coordinatorPhone;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mesaj legat de odificare acțiune '. $this->eventName.' - eco4',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.action_modified_email',
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
