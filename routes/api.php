<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('admin')->group(function(){
    Route::post('/add', [VehicleController::class, 'add']);
    Route::put('/edit', [VehicleController::class, 'edit']);
    Route::delete('/delete', [VehicleController::class, 'delete']);
});

Route::prefix('user')->group(function(){
    Route::post('/reserve', [ReservationController::class, 'reserve']);
});
