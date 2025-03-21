<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){

    Route::post('/register',[AuthController::class,'register']);
    Route::apiResources(['plants','orders','images'],   );
});
