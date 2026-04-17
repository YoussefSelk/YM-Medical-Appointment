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
        $this->content = nl2br(e((string) ($data['content'] ?? '')));
        $this->contactLink = filter_var($data['contactLink'] ?? '', FILTER_VALIDATE_URL)
            ? $data['contactLink']
            : config('app.url');
        $this->contactText = trim(strip_tags((string) ($data['contactText'] ?? 'Contact us')));
        $this->phoneNumber = preg_replace('/[^0-9+\\-\\s\\(\\)]/', '', (string) ($data['phoneNumber'] ?? ''));
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
