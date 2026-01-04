<?php

namespace App\Http\Controllers\Views;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Contracts\Auth\Services\IAuthService;
use App\DTOs\Auth\Registro\RegisterDTO;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function __construct(
        private IAuthService $authService
    ){}

    public function iniciarRegistro(RegisterRequest $request): RedirectResponse
    {
        try {
            // La lógica de preparación sigue siendo la misma (¡Esto es bueno!)
            $dto = RegisterDTO::fromRequest($request->validated());

            $result = $this->authService->iniciarRegistro($dto);

            // En lugar de JSON, rediriges a la siguiente página (ej. verificar código)
            // Usamos with() para enviar mensajes flash a la sesión
            return redirect()->route('auth.verificar-correo')
                ->with('status', $result['message'])
                ->with('cuenta_id', $result['cuenta_id'])
                ->with('datosEncriptados', $result['datosEncriptados']);

        } catch (ValidationException $e) {
            // Laravel maneja automáticamente las ValidationException en rutas web
            // redirigiendo atrás con los errores de validación.
            throw $e;

        } catch (\Exception $e) {
            // Logueamos el error internamente
            Log::error("Error en registro: " . $e->getMessage());

            // Redirigimos atrás con un mensaje de error para el usuario
            return back()->withInput()->withErrors([
                'error' => config('app.debug') ? $e->getMessage() : 'Error interno, inténtalo más tarde'
            ]);
        }
    }
}
