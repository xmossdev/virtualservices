<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponseTrait;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    use ApiResponseTrait;

    private $message = [
        'id.required'           => 'ID wymagane!',
        'id.integer'            => 'ID musi być integer!',
        'id.exists'             => 'Nie istnieje pojazd o podanym ID!',
        'name.required'         => 'Nazwa wymagana!',
        'key.required'          => 'Klucz wymagany!',
        'key.unique'            => 'Klucz musi być unikalny!',
        'type.required'         => 'Typ wymagany!',
    ];

    public function add(Request $request){
        $arrRules = [
            'name'  => 'required',
            'type'  => 'required',
            'key'   => 'required|unique:vehicles,key',
        ];
        if($error = $this->isValid($arrRules, $this->message)) return $error;
        try{
            Vehicle::create($request->toArray());
            return $this->createResponse(200);
        }catch (\Exception $e){
            return $this->catchException($e);
        }
    }

    public function edit(Request $request){
        $arrRules = [
            'id' => 'required|integer|exists:vehicles,id',
        ];
        if($error = $this->isValid($arrRules, $this->message)) return $error;
        try{
            Vehicle::where('id', $request->id)
                ->update($request->toArray());
            return $this->createResponse(200);
        }catch (\Exception $e){
            return $this->catchException($e);
        }
    }

    public function delete(Request $request){
        $arrRules = [
            'id' => 'required|integer|exists:vehicles,id',
        ];
        if($error = $this->isValid($arrRules, $this->message)) return $error;
        try{
            Vehicle::where('id', $request->id)
                ->delete();
            return $this->createResponse(200);
        }catch (\Exception $e){
            return $this->catchException($e);
        }
    }

}
