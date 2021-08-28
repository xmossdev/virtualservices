<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponseTrait;
use App\Mail\NewReservation;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    use ApiResponseTrait;

    private $message = [
        'id.required'           => 'ID wymagane!',
        'id.integer'            => 'ID musi być integer!',
        'id.exists'             => 'Nie istnieje pojazd o podanym ID!',
        'email.required'        => 'Email wymagany!',
        'email.email'           => 'Niepoprawny format email!',
        'from.required'         => 'Wymagana data od',
        'to.required'           => 'Wymagana data do',
        'from.date'             => 'Niewłaściwy format daty od',
        'to.date'               => 'Niewłaściwy format daty do',
        'to.afterOrEqual'       => 'Data do musi być równa lub po dacie od!',
    ];

    public function reserve(Request $request){
        $arrRules = [
            'id'    => 'required|integer|exists:vehicles,id',
            'email' => 'required|email',
            'from'  => 'required|date',
            'to'    => 'required|date|afterOrEqual:from',
        ];
        if($error = $this->isValid($arrRules, $this->message)) return $error;
        try{
            if(Reservation::where('vehicleId', '=', $request->id)
                ->where(
                    function($query) use ($request){
                        $query->whereBetween('from', [$request->from, $request->to]);
                        $query->orWhereBetween('to', [$request->from, $request->to]);
                    }
                )->count() == 0
            ){
                $boredJson = Http::get('https://www.boredapi.com/api/activity?participants=1')->json();
                $arrReservation = [
                    'vehicleId' => $request->id,
                    'email'     => $request->email,
                    'type'      => $boredJson['type'],
                    'key'       => $boredJson['key'],
                    'from'      => $request->from,
                    'to'        => $request->to,
                ];
                DB::beginTransaction();
                Reservation::create($arrReservation);
                Mail::to($request->email)->send(new NewReservation($arrReservation));
                DB::commit();
                return $this->createResponse(200, 'Utworzono rezerwacje!');
            }
            return $this->createResponse(400, 'Termin niedostępny!');
        }catch (\Exception $e){
            DB::rollback();
            return $this->catchException($e);
        }
    }
}
