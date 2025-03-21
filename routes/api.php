<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlantController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){

    Route::post('/register',[AuthController::class,'register']);
    Route::middleware(['auth'])->group(function(){
        Route::apiResource('plants',PlantController::class);
    });
});
