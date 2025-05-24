<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Resource route untuk CRUD lengkap
Route::resource('products', ProductController::class);

Route::get('hospitals/csv/files', [HospitalController::class, 'listCsvFiles']);