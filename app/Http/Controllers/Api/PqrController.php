<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pqrs;
use Illuminate\Support\Facades\Validator;

class PqrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pqrs = Pqrs::all();
        $data = [
            'pqrs' => $pqrs,
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
            'usuario_id' => 'required|integer',
            'mensaje'    => 'required|string|max:255',
            'motivo_id'  => 'required|integer',
            'estado_id'  => 'required|integer'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }

        $pqr = Pqrs::create([
            'usuario_id' => $request->usuario_id,
            'mensaje'    => $request->mensaje,
            'motivo_id'  => $request->motivo_id,
            'estado_id'  => $request->estado_id
        ]);

        if (!$pqr) {
            $data = [
                'message' => 'Error al crear la PQR',
                'status'  => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'pqr'    => $pqr,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pqr = Pqrs::find($id);
        if (!$pqr) {
            $data = [
                'message' => 'PQR no encontrada',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'pqr'    => $pqr,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pqr = Pqrs::find($id);
        if (!$pqr) {
            $data = [
                'message' => 'PQR no encontrada',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'usuario_id' => 'required|integer',
            'mensaje'    => 'required|string|max:512',
            'motivo_id'  => 'required|integer',
            'estado_id'  => 'required|integer'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }

        $pqr->update($request->only(['usuario_id', 'mensaje', 'motivo_id', 'estado_id']));

        $data = [
            'pqr'    => $pqr,
            'message' => 'PQR actualizada correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pqr = Pqrs::find($id);
        if (!$pqr) {
            $data = [
                'message' => 'PQR no encontrada',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $pqr->delete();
        $data = [
            'message' => 'PQR eliminada correctamente',
            'status'  => 200
        ];
        return response()->json($data, 200);
    }
}
