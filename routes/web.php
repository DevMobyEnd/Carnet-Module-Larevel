<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarnetController;

Route::get('/', [CarnetController::class, 'index'])->name('carnet.index');
Route::post('/process', [CarnetController::class, 'processCsv'])->name('carnet.process');
Route::post('/carnet/send-all', [CarnetController::class, 'sendAll'])->name('carnet.sendAll');
Route::get('/carnet/result', [CarnetController::class, 'result'])->name('carnet.result');

Route::get('/test-email', [CarnetController::class, 'testEmail']);