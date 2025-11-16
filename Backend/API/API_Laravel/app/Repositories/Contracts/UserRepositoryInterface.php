<?php

namespace App\Repositories\Contracts;

use App\Models\Usuario;
use App\DTOs\Auth\RegisterDTO;

/**
 * Interfaz del repositorio de usuarios
 * 
 * Define el contrato que deben cumplir todas las implementaciones
 * del repositorio de usuarios (por ejemplo, Eloquent, o uno falso para testing).
 */
interface UserRepositoryInterface
{
    /**
     * Crear un nuevo usuario en la base de datos
     *
     * @param RegisterDTO $dto - Datos del usuario a crear
     * @param int $correoId - ID del correo asociado al usuario
     * @return Usuario - El usuario creado con su ID asignado
     */
    public function create(RegisterDTO $dto, int $correoId): Usuario;

    /**
     * Buscar un usuario por el ID del correo asociado
     *
     * SQL -> SELECT * FROM usuarios WHERE correo_id = ? LIMIT 1
     *
     * @param int $correoId - ID del correo
     * @return Usuario|null - El usuario encontrado o null si no existe
     */
    public function findByCorreoId(int $correoId): ?Usuario;

    /**
     * Buscar un usuario por su ID
     *
     * @param int $id - ID del usuario
     * @return Usuario|null - El usuario encontrado o null si no existe
     */
    public function findById(int $id): ?Usuario;

    /**
     * Actualizar la fecha de última actividad del usuario
     *
     * @param int $userId - ID del usuario a actualizar
     * @return void
     */
    public function updateLastActivity(int $userId): void;

    /**
     * Verifica si existe un usuario con un correo dado
     *
     * SQL -> SELECT EXISTS(SELECT * FROM usuarios WHERE correo_id = ?)
     *
     * @param int $correoId - ID del correo a verificar
     * @return bool - true si existe, false si no
     */
    public function existsByCorreoId(int $correoId): bool;

    /**
     * Invalidar todos los tokens JWT del usuario
     *
     * Propósito:
     * Permite invalidar todos los tokens activos cuando el usuario
     * cierra sesión en todos los dispositivos.
     *
     * @param int $userId - ID del usuario
     * @return bool - true si se invalidaron, false si hubo error
     */
    public function invalidateAllTokens(int $userId): bool;

    public function existsByEmail(string $email): bool;

}
