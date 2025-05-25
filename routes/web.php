<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TesisController; // <-- ¡Añade esta línea!
use App\Http\Controllers\CarreraController; // Asegúrate de que este use esté presente si tienes CarreraController


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para descargar el PDF
    Route::get('/tesis/{id}/download-pdf', [TesisController::class, 'downloadPdf'])->name('tesis.downloadPdf');
     // ¡AÑADE ESTA LÍNEA para las rutas de Tesis!
    Route::resource('tesis', TesisController::class);
    // Rutas del recurso Carreras (si tienes uno)
    Route::resource('carreras', CarreraController::class);
});

require __DIR__.'/auth.php';
