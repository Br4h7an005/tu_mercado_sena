<?php

namespace App\Repositories;

use App\DTOs\Auth\RegisterDTO;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 * UserRepository - Implementación del repositorio de usuarios
 * 
 * RESPONSABILIDADES:
 * - Acceso a datos (Eloquent ORM)
 * - Transformar DTOs en modelos
 * - Hashear contraseñas antes de guardar
 * - Asignar valores por defecto (rol, estado)
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Crear un nuevo usuario en la base de datos
     * 
     * PROCESO:
     * 1. Convierte el DTO a array
     * 2. Hashea la contraseña
     * 3. Asigna correo_id, rol_id y estado_id
     * 4. Crea el usuario en la BD
     * 
     * @param RegisterDTO $dto
     * @param int $correoId - ID del correo asociado
     * @return Usuario
     */
    public function create(RegisterDTO $dto, int $correoId): Usuario
    {
        $data = $dto->toArray();

        // Asignar el ID del correo (ahora entero)
        $data['correo_id'] = $correoId;

        // Hashear la contraseña (cumple RNF007)
        $data['password'] = Hash::make($data['password']);

        // Rol y estado por defecto
        $data['rol_id'] = 1;     // 1 = Usuario normal
        $data['estado_id'] = 1;  // 1 = Activo

        // Crear usuario y retornar el modelo
        return Usuario::create($data);
    }

    /**
     * Buscar usuario por el ID del correo
     * 
     * SQL -> SELECT * FROM usuarios WHERE correo_id = ? LIMIT 1
     * 
     * @param int $correoId
     * @return Usuario|null
     */
    public function findByCorreoId(int $correoId): ?Usuario
    {
        return Usuario::where('correo_id', $correoId)->first();
    }

    /**
     * Buscar un usuario por ID (primary key)
     * 
     * @param int $id
     * @return Usuario|null
     */
    public function findById(int $id): ?Usuario
    {
        return Usuario::find($id);
    }

    /**
     * Actualizar la fecha de última actividad del usuario
     * 
     * @param int $userId
     * @return void
     */
    public function updateLastActivity(int $userId): void
    {
        Usuario::where('id', $userId)->update([
            'fecha_reciente' => now()
        ]);
    }

    /**
     * Verificar si existe un usuario asociado a un correo
     * 
     * SQL -> SELECT EXISTS(SELECT * FROM usuarios WHERE correo_id = ?);
     * 
     * @param int $correoId
     * @return bool
     */
    public function existsByCorreoId(int $correoId): bool
    {
        return Usuario::where('correo_id', $correoId)->exists();
    }

    /**
     * Invalidar todos los tokens JWT del usuario
     * 
     * @param int $userId
     * @return bool
     */
    public function invalidateAllTokens(int $userId): bool
    {
        $user = Usuario::find($userId);

        if ($user) {
            $user->jwt_invalidated_at = Carbon::now();
            return $user->save();
        }

        return false;
    }

    public function existsByEmail(string $email): bool
{
    return Usuario::whereHas('correo', function ($q) use ($email) {
        $q->where('correo', $email);
    })->exists();
}

}
