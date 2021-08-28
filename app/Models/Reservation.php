<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'vehicleId',
        'email',
        'key',
        'type',
        'from',
        'to',
    ];

    public function getVehicle(){
        return $this->hasOne(Vehicle::class,'id','vehicleId')->get();
    }

}
