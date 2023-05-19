<?php

namespace App\Mail;

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $company_name;
    public $contact_name;
    public $phone;
    public $email;
    public $contact_message;

    /**
     * Create a new message instance.
     *
     * @param $company_name
     * @param $contact_name
     * @param $phone
     * @param $email
     * @param $message
     */
    public function __construct($company_name, $contact_name, $phone, $email, $contact_message)
    {
        $this->company_name = $company_name;
        $this->contact_name = $contact_name;
        $this->phone = $phone;
        $this->email = $email;
        $this->contact_message = $contact_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mesaj de contact')
            ->view('emails.contact');
    }
}
