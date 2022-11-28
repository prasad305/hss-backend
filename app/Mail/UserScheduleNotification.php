<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserScheduleNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     private $remainders;

    public function __construct($remainders)
    {
        $this->remainders = $remainders;
    }

    public function build()
    {
        return $this->markdown('Others.schedule_message')->with('remainders',$this->remainders);
    }
}
