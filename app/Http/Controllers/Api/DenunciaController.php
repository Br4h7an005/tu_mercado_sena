<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Denuncia;
use Illuminate\Support\Facades\Validator;

class DenunciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $denuncias = Denuncia::all();
        $data = [
            'denuncias' => $denuncias,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'producto_id' => 'required|integer',
            'usuario_id'  => 'required|integer',
            'chat_id'     => 'required|integer',
            'motivo_id'   => 'required|integer',
            'estado_id'   => 'required|integer'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }

        $denuncia = Denuncia::create([
            'producto_id' => $request->producto_id,
            'usuario_id'  => $request->usuario_id,
            'chat_id'     => $request->chat_id,
            'motivo_id'   => $request->motivo_id,
            'estado_id'   => $request->estado_id
        ]);

        if (!$denuncia) {
            $data = [
                'message' => 'Error al crear la denuncia',
                'status'  => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'denuncia' => $denuncia,
            'message'  => 'Denuncia creada correctamente',
            'status'   => 201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $denuncia = Denuncia::find($id);
        if (!$denuncia) {
            $data = [
                'message' => 'Denuncia no encontrada',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'denuncia' => $denuncia,
            'status'   => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $denuncia = Denuncia::find($id);
        if (!$denuncia) {
            $data = [
                'message' => 'Denuncia no encontrada',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'producto_id' => 'sometimes|integer',
            'usuario_id'  => 'sometimes|integer',
            'chat_id'     => 'sometimes|integer',
            'motivo_id'   => 'sometimes|integer',
            'estado_id'   => 'sometimes|integer'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }

        $denuncia->update($request->all());

        $data = [
            'denuncia' => $denuncia,
            'message'  => 'Denuncia actualizada correctamente',
            'status'   => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $denuncia = Denuncia::find($id);
        if (!$denuncia) {
            $data = [
                'message' => 'Denuncia no encontrada',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $denuncia->delete();
        $data = [
            'message' => 'Denuncia eliminada correctamente',
            'status'  => 200
        ];
        return response()->json($data, 200);
    }
}
