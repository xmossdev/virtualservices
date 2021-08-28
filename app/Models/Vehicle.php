<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'key',
        'type',
    ];

    public function reservations(){
        return $this->hasMany(
            Reservation::class,
            'vehicleId',
            'id'
        );
    }

}
