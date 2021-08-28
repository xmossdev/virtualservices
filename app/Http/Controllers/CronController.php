<?php

namespace App\Http\Controllers;

use App\Mail\RemindReservation;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CronController extends Controller
{
    public function sendEmailDayBeforeReservation(){
        try{
            $objReservations = Reservation::whereDate('from', now()->addDay(1))->get();
            foreach ($objReservations as $reservation){
                Mail::to($reservation->email)->send(new RemindReservation($reservation->toArray()));
                Log::info('Wysłano przypomnienie o rezerwacji id='.$reservation->id);
            }
        }catch (\Exception $e){
            Log::error($e->getMessage(), $e->getTrace());
        }
    }
}
