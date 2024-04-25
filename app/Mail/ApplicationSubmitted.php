<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = 'New Application Submitted';
    public $name;
    public $email;
    public $details;
    public $cvPath;

    /**
     * Create a new message instance.
     *
     * @param  string  $name
     * @param  string  $email
     * @param  string  $details
     * @param  string  $cvPath
     * @return void
     */
    public function __construct($name, $email, $details, $cvPath)
    {
        $this->name = $name;
        $this->email = $email;
        $this->details = $details;
        $this->cvPath = $cvPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->subject)
            ->from('no.reply.ym.system@gmail.com', 'YM | Support')
            ->to('no.reply.ym.system@gmail.com')
            ->view('Email.Application-submitted')
            ->attach($this->cvPath);
    }
}
