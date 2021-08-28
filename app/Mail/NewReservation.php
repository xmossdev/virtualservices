<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewReservation extends Mailable
{
    use Queueable, SerializesModels;

    public $arrReservation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $reservation)
    {
        $this->arrReservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-response@domena.pl','System rezerwacyjny')
            ->subject('Nowa rezerwacja')
            ->view('newReservation');
    }
}
