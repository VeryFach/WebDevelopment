<?php

use App\Http\Controllers\Api\HospitalController;

Route::prefix('hospitals')->group(function () {
    Route::get('/', [HospitalController::class, 'index']);
    Route::get('/search', [HospitalController::class, 'search']);
    Route::get('/nearest', [HospitalController::class, 'nearest']);
    Route::get('/statistics', [HospitalController::class, 'statistics']);
    Route::get('/csv/files', [HospitalController::class, 'listCsvFiles']);
    Route::get('/csv/download/{filename}', [HospitalController::class, 'downloadCsv']);
    Route::get('/{id}', [HospitalController::class, 'show']);
});