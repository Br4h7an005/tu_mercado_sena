<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bloqueado;
use Illuminate\Support\Facades\Validator;
class BloqueadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bloqueados = Bloqueado::all();
        $data = [
            'bloqueados' => $bloqueados,
            'status'  => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bloqueador_id' => 'required|integer',
            'bloqueado_id'  => 'required|integer'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }
        $bloqueado = Bloqueado::create([
            'bloqueador_id' => $request->bloqueador_id,
            'bloqueado_id'  => $request->bloqueado_id
        ]);
        if (!$bloqueado) {
            $data = [
                'message' => 'Error al crear el bloqueado',
                'status'  => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'bloqueado' => $bloqueado,
            'message' => 'Bloqueado creado correctamente',
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bloqueado = Bloqueado::find($id);
        if (!$bloqueado) {
            $data = [
                'message' => 'Bloqueado no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'bloqueado' => $bloqueado,
            'status'    => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bloqueado = Bloqueado::find($id);
        if (!$bloqueado) {
            $data = [
                'message' => 'Bloqueado no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'bloqueador_id' => 'sometimes|required|integer',
            'bloqueado_id'  => 'sometimes|required|integer'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }
            $bloqueado->update($request->only(['bloqueador_id', 'bloqueado_id']));
        if (!$bloqueado) {
            $data = [
                'message' => 'Error al actualizar el bloqueado',
                'status'  => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'bloqueado' => $bloqueado,
            'message' => 'Bloqueado actualizado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bloqueado = Bloqueado::find($id);
        if (!$bloqueado) {
            $data = [
                'message' => 'Bloqueado no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $deleted = $bloqueado->delete();
        if (!$deleted) {
            $data = [
                'message' => 'Error al eliminar el bloqueado',
                'status'  => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'message' => 'Bloqueado eliminado correctamente',
            'status'  => 200
        ];
        return response()->json($data, 200);
    }
}
