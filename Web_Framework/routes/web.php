<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HospitalController;


Route::get('/', function () {
    return view('welcome');
});

// Resource route untuk CRUD lengkap
Route::resource('products', ProductController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Hospital API Routes
Route::prefix('hospitals')->group(function () {
    Route::get('/', [HospitalController::class, 'index']);
    Route::get('/search', [HospitalController::class, 'search']);
    Route::get('/nearest', [HospitalController::class, 'nearest']);
    Route::get('/statistics', [HospitalController::class, 'statistics']);
    Route::get('/csv/files', [HospitalController::class, 'listCsvFiles']);
    Route::get('/csv/download/{filename}', [HospitalController::class, 'downloadCsv']);
    Route::get('/{id}', [HospitalController::class, 'show']);
});