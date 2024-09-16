<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('New Contact Form Submission')
                    ->from('info@akashpoweryogastudio.com')
                    ->to('info@akashpoweryogastudio.com')
                    ->view('emails.contact_submitted')
                    ->with(['data' => $this->data]);
    }
}
