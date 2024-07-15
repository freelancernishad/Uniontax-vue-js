<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VillageCourtController;

Route::group(['prefix' => 'village-courts'], function () {
    Route::get('/', [VillageCourtController::class, 'index']);
    Route::post('/', [VillageCourtController::class, 'store']);
    Route::get('/{id}', [VillageCourtController::class, 'show']);
    Route::put('/{id}', [VillageCourtController::class, 'update']);
    Route::delete('/{id}', [VillageCourtController::class, 'destroy']);
});