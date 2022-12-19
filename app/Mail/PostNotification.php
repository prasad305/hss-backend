<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $postInfo;
    public $senderInfo;

    public function __construct($postInfo,$senderInfo)
    {
        $this->postInfo = $postInfo;
        $this->senderInfo = $senderInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $postInfo = $this->postInfo;
        $senderInfo = $this->senderInfo;
        return $this->subject('Approve Post')->view('Others.MailView.postView', compact('postInfo','senderInfo'));
    }
}
