<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::all();
        $data = [
            'notificaciones' => $notificaciones,
            'status' => 200
        ];
        return response()->json($data, 200);
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'required|integer',
            'motivo_id'  => 'required|integer',
            'mensaje'    => 'required|string|max:255',
            'visto'      => 'boolean'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }

        

        $notificacion = Notificacion::create([
            'usuario_id' => $request->usuario_id,
            'motivo_id'  => $request->motivo_id,
            'mensaje'    => $request->mensaje,
            'visto'      => $request->visto 
        ]);

        if (!$notificacion) {
            $data = [
                'message' => 'Error al crear la notificación',
                'status'  => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'notificacion' => $notificacion,
            'status'       => 201
        ];
        return response()->json($data, 201);
    }

    public function show(string $id)
    {
        $notificacion = Notificacion::findOrFail($id);
        if (!$notificacion) {
            $data = [
                'message' => 'Notificación no encontrada',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'notificacion' => $notificacion,
            'status'       => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, string $id)
    {
        $notificacion = Notificacion::find($id);

        if (!$notificacion) {
            $data = [
                'message' => 'Notificación no encontrada',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'usuario_id' => 'integer',
            'motivo_id'  => 'integer',
            'mensaje'    => 'string|max:255',
            'visto' => 'boolean'

        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }

            $notificacion->update($request->only(['usuario_id', 'motivo_id', 'mensaje', 'visto']));


        $data = [
            'notificacion' => $notificacion,
            'message'      => 'Notificación actualizada correctamente',
            'status'       => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy(string $id)
    {
        $notificacion = Notificacion::find($id);

        if (!$notificacion) {
            $data = [
                'message' => 'Notificación no encontrada',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $notificacion->delete();
        $data = [
            'message' => 'Notificación eliminada correctamente',
            'status'  => 200
        ];
        return response()->json($data, 200);
    }
}
