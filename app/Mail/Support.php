<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Support extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = 'Support';
    public $content;
    public $contactLink;
    public $contactText;
    public $phoneNumber;

    /**
     * Create a new message instance.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->content = $data['content'];
        $this->contactLink = $data['contactLink'];
        $this->contactText = $data['contactText'];
        $this->phoneNumber = $data['phoneNumber'];
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
            ->view('Email.Support', [
                'subject' => $this->subject,
                'content' => $this->content,
                'contactLink' => $this->contactLink,
                'contactText' => $this->contactText,
                'phoneNumber' => $this->phoneNumber,
            ]);
    }
}
