<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RemindReservation extends NewReservation
{
    public function build()
    {
        return $this->from('no-response@domena.pl','System rezerwacyjny')
            ->subject('Przypomnienie o rezerwacji')
            ->view('remindReservation');
    }
}
