<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TesisController; // <-- ¡Añade esta línea!
use App\Http\Controllers\CarreraController; // Asegúrate de que este use esté presente si tienes CarreraController
use App\Http\Controllers\UserController; // <-- ¡Añade esta línea!
use App\Http\Controllers\DashboardController; // <-- ¡Añade esta línea!



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']) // <-- CAMBIO AQUÍ
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para descargar el PDF
    Route::get('/tesis/{id}/download-pdf', [TesisController::class, 'downloadPdf'])->name('tesis.downloadPdf');
    //  // ¡AÑADE ESTA LÍNEA para las rutas de Tesis!
    // Route::resource('tesis', TesisController::class);
    // // Rutas del recurso Carreras (si tienes uno)
    // Route::resource('carreras', CarreraController::class);

    // // Rutas para la gestión de usuarios
    // Route::resource('users', UserController::class); // <-- ¡Añade esta línea!
    // Rutas de Tesis que solo los administradores pueden usar
    Route::middleware('admin')->group(function () {
        Route::resource('tesis', TesisController::class)->except(['index', 'show']); // Solo create, store, edit, update, destroy
        Route::resource('carreras', CarreraController::class); // Todas las acciones de carreras para admin
        Route::resource('users', UserController::class); // Todas las acciones de usuarios para admin
    });

    // Rutas de Tesis que todos los usuarios autenticados pueden usar
    Route::get('/tesis', [TesisController::class, 'index'])->name('tesis.index');
    Route::get('/tesis/{tesi}', [TesisController::class, 'show'])->name('tesis.show');

    
});

require __DIR__.'/auth.php';
