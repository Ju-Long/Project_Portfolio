<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public $random_str;

    public function __construct($random_str)
    {
        $this->random_str = $random_str;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Signup Confirmation")->view('emails.signup');
    }
}
