<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $welcome;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($welcome)
    {
        //
        $this->welcome = $welcome;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.welcome',
            ['welcome' => $this->welcome]
        )
            ->from('no-reply@law_firm_X.com', 'Law Firm X')
            ->subject('Welcome to Law Firm X CRM');
    }
}
