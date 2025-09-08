<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NotificacionController;
use App\Http\Controllers\Api\DenunciaController;
use App\Http\Controllers\Api\PqrController;
use App\Http\Controllers\Api\MotivoController;
use App\Http\Controllers\Api\EstadoController;
use App\Http\Controllers\Api\BloqueadoController;
use App\Http\Controllers\Api\PapeleraController;
use App\Http\Controllers\Api\CorreoController;
use App\Http\Controllers\AuthController;


Route::apiResource('notificaciones', NotificacionController::class);
Route::apiResource('denuncias', DenunciaController::class);
Route::apiResource('pqrs', PqrController::class);
Route::apiResource('motivos', MotivoController::class);
Route::apiResource('estados', EstadoController::class);
Route::apiResource('bloqueados', BloqueadoController::class);
Route::apiResource('papeleras', PapeleraController::class);
Route::apiResource('correos', CorreoController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
