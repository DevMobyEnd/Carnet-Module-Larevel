<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarnetController;

Route::get('/', [CarnetController::class, 'index'])->name('carnet.index');
Route::post('/process', [CarnetController::class, 'processCsv'])->name('carnet.process');
Route::post('/carnet/send-all', [CarnetController::class, 'sendAll'])->name('carnet.sendAll');
Route::get('/carnet/result', [CarnetController::class, 'result'])->name('carnet.result');

// Route::get('/test-email', [CarnetController::class, 'testEmail']);

Route::get('/preview-carnet', function () {
    return view('carnet.carnet', [
        'aprendiz' => 'Nombre del Aprendiz',
        'documento' => '1234567890',
        'ficha' => '1234567',
        'programa' => 'Nombre del Programa',
        'photo' => 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('img/placeholder.jpg'))),
        'qr_code' => '<img src="' . asset('img/qr-placeholder.png') . '" alt="QR Code">'
    ]);
});