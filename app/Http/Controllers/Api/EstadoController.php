<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estado;
use Illuminate\Support\Facades\Validator;
class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = Estado::all();
        $data = [
            'estados' => $estados,
            'status'  => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:32',
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

        $estado = Estado::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        if (!$estado) {
            $data = [
                'message' => 'Error al crear el estado',
                'status'  => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'estado' => $estado,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estado = Estado::find($id);
        if (!$estado) {
            $data = [
                'message' => 'Estado no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'estado' => $estado,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $estado = Estado::find($id);
        if (!$estado) {
            $data = [
                'message' => 'Estado no encontrado',
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

        $estado->nombre = $request->nombre;
        $estado->descripcion = $request->descripcion;
        $estado->save();

        $data = [
            'estado' => $estado,
            'message' => 'Estado actualizado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estado = Estado::find($id);
        if (!$estado) {
            $data = [
                'message' => 'Estado no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $estado->delete();
        $data = [
            'message' => 'Estado eliminado correctamente',
            'status'  => 200
        ];
        return response()->json($data, 200);
    }
}
