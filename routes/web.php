<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarnetController;

Route::get('/', [CarnetController::class, 'index'])->name('carnet.index');
Route::post('/process', [CarnetController::class, 'processCsv'])->name('carnet.process');