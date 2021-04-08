<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $body;
    private $_subject;
    private $_view;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($body,$_subject,$view)
    {
        $this->body = $body;
        $this->_subject = $_subject;
        $this->_view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject($this->_subject)
        ->view( $this->_view)->with([
                        'body' => $this->body,
                        'subject' => $this->subject,
                    ]);
    }
}

