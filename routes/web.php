<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'iniciarSesion'])->name('login.attempt');

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrarCliente'])->name('registro.store');

Route::get('/dashboard', [AuthController::class, 'mostrarDashboard'])->name('dashboard');

Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');