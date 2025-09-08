<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motivo;
use Illuminate\Support\Facades\Validator;

class MotivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motivos = Motivo::all();
        $data = [
            'motivos' => $motivos,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }
        $motivo = Motivo::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion
        ]);
        if (!$motivo) {
            $data = [
                'message' => 'Error al crear el motivo',
                'status'  => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'motivo' => $motivo,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $motivo = Motivo::find($id);
        if (!$motivo) {
            $data = [
                'message' => 'Motivo no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'motivo' => $motivo,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $motivo = Motivo::find($id);
        if (!$motivo) {
            $data = [
                'message' => 'Motivo no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:32',
            'descripcion' => 'required|string|max:128'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }

            $motivo->update($request->only(['nombre', 'descripcion']));

        $data = [
            'motivo' => $motivo,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $motivo = Motivo::find($id);
        if (!$motivo) {
            $data = [
                'message' => 'Motivo no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $motivo->delete();
        $data = [
            'message' => 'Motivo eliminado correctamente',
            'status'  => 200
        ];
        return response()->json($data, 200);
    }
}
