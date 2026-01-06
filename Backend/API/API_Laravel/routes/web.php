<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Views\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return view('auth.login');
})->name('login');


Route::get('/verificar-correo', [AuthController::class, 'verificarCorreo'])->name('auth.verificar-correo');

Route::post('/iniciar-registro', [AuthController::class, 'iniciarRegistro'])->name('auth.iniciar-registro');


