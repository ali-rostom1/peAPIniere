<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){

    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
    Route::post('refresh',[AuthController::class,'refreshToken']);

    Route::middleware(['auth'])->group(function(){
        Route::apiResource('plants',PlantController::class);
        Route::apiResource('orders',OrderController::class);

        Route::get('my-orders',[OrderController::class,'getMyorders']);
        Route::post('my-orders/cancel',[OrderController::class,'cancelMyOrder']);
        Route::post('orders/cancel',[OrderController::class,'cancelAllOrders']);
        Route::post('orders/preparing',[OrderController::class,'markAsPreparing']);
        Route::post('orders/delivered',[OrderController::class,'markAsDelivered']);

        Route::get('stats/delivered-orders',[StatisticsController::class,'getDeliveredOrdersCount']);
        Route::get('stats/plants',[StatisticsController::class,'getPlantsCount']);
        Route::get('stats/top-3-ordered-plants',[StatisticsController::class,'getTop3OrderedPlants']);
        Route::get('stats/top-3-categories',[StatisticsController::class,'getTop3PlantCategories']);

        Route::post('logout',[AuthController::class,'logout']);

    });
});
