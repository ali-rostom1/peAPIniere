<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){

    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
    Route::post('refresh',[AuthController::class,'refreshToken']);

    Route::middleware(['auth'])->group(function(){
        Route::apiResource('plants',PlantController::class);
        Route::post('logout',[AuthController::class,'logout']);

    });
});
