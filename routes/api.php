<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Business\ServiceController;

Route::post('login',[AuthController::class, 'login']);
Route::post('register',[AuthController::class, 'register']);

Route::apiResource('user', UserController::class);
Route::apiResource('business', BusinessController::class);

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('service', ServiceController::class);
    Route::post('update_service/{id}',[ServiceController::class, 'update']);
    Route::apiResource('booking', BookingController::class);
});

// Bisa gunakan post untuk update
Route::post('update_business/{id}',[BusinessController::class, 'update']);

Route::get('/auth', function(){
    return response()->json(['message'=>'Silahkan login dahulu']);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
 