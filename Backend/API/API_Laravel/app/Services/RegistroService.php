<?php

namespace App\Services;

use App\Contracts\ICorreoRepository;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Auth\VerificationCodeDTO;
use App\Models\Correo;
use App\DTOs\Auth\VerifyCode;
use Illuminate\Support\Facades\Log;
use App\Repositories\CorreoRepository;

class RegistroService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private ICorreoRepository $correoRepository,
        private CorreoService $correoService,
    )
    {}

    /**
     * PASO 1: Iniciar el proceso de registro
     * - Valida que el correo sea institucional
     * - Genera una clave de verificación 
     * - Guarda el correo y la clave en la BD
     * - Envía el correo con la clave
     * 
     * @param RegisterDTO $dto
     * @return array ['success' => bool, 'message' => string]
     */
    public function iniciarRegistro(RegisterDTO $dto): array
    {
        try {

            // Verificar si el correo ya está registrado
            if ($this->correoRepository->isCorreoVigente($dto->correo)) {
                return [
                    'success' => false,
                    'message' => 'Este correo ya esta registrado en el sistema'
                ];
            }
    
            // Generar clave de verificacion
            $clave = Correo::generarClave();
    
            // Actualizar en base de datos
            $correoExistente = $this->correoRepository->findByCorreo($dto->correo);
    
            if ($correoExistente) {
                // Si existe el correo, actualizar clave
                $correo = $this->correoRepository->actualizarClave($correoExistente, $clave);
            } else {
                // Si no existe, crear nuevo registro
                $correo = $this->correoRepository->createOrUpdate($dto->correo, $clave);
            }

    
            // Enviar correo electrónico con la clave
            $emailEnviado = $this->correoService->enviarCodigoVerificacion($dto->correo, $clave);
    
            // Verificar si el correo se envió correctamente
            if (!$emailEnviado) {
                // Log de error
                Log::error('Error al enviar el correo de verificación', [
                    'correo' => $dto->correo,
                ]);
    
                return [
                    'success' => false,
                    'message' => 'No se pudo enviar el correo de verificación. Intente nuevamente más tarde.',
                    'data' => null
                ];
            }
    
            return [
                'success' => true,
                'message' => 'Código de verificación enviado correctamente',
                'data' => [
                    'correo' => $dto->correo,
                    'expira_en' => $correo->fecha_mail->toDateTimeString(),
                ]
            ];

        } catch (\Exception $e) {
            Log::error('Excepción en iniciarRegistro', [
                'error' => $e->getMessage(),
                'correo' => $dto->correo,
            ]);

            return [
                'success' => false,
                'message' => 'Ocurrió un error al iniciar el registro. Intente nuevamente más tarde.',
                'data' => null
            ];
        } 
    }

    /**
     * PASO 2: Verificar el código de verificación
     * - Busca el correo en la tabla correos
     * - Valida que la clave coincida y no haya expirado
     * 
     * @param RegisterDTO $registerDto
     * @param VerifyCode $dto
     * @return array ['success' => bool, 'message' => string]
     */
    public function verificarClave(RegisterDTO $registerDto, VerifyCode $dto): array
    {
        try {
            // Buscar el correo en la base de datos
            $correo = $this->correoRepository->findByCorreo($registerDto->correo);

            if (!$correo) {
                return [
                    'success' => false,
                    'message' => 'No se encontro una solicitud de registro',
                    'data' => null,
                ];
            }

            // Verificar si la clave ha expirado
            if($correo->hasExpired()) {
                return [
                    'success' => false,
                    'message' => 'La clave ha expirado. Solicita una nueva clave',
                    'data' => null,
                ];
            }

            // Verificar que la clave coindicda
            if (!$correo->isValidClave($dto->clave)) {
                return [
                    'success' => false,
                    'message' => 'La clave es incorrecta, intanta nuevamente',
                    'data' => null
                ];
            }
            
            // Clave verificada correctamente
            return [
                'success' => true,
                'message' => 'Código verificado correctamente',
                'data' => [
                    'correo' => $registerDto->correo,
                    'clave_verificada' => true
                ]
            ];

        } catch (\Exception $e) {
            Log::error('Error en la verificar clave', [
                'correo' => $registerDto->correo,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Ocurrió un error al verificar el código. Por favor intentalo más tarde',
                'data' => null,
            ];
        }
    }

    /**
     * Limpiar registros temporales expirados (más de 1 hora)
     * Este método puede ejecutarse mediante un comando Artisan o un job programado
     */
    public function limpiarRegistrosExpirados(): int
    {
        $correos = Correo::where('clave_generada_at', '<', now()->subHour())->get();
        $cantidad = $correos->count();

        foreach ($correos as $correo) {
            $this->correoRepository->deleteExpired();
        }

        Log::info("Limpieza de registros expirados: {$cantidad} registros eliminados");

        return $cantidad;
    }

}
