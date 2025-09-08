<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Correo;
use Illuminate\Support\Facades\Validator;
class CorreoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $correos = Correo::all();
        $data = [
            'correos' => $correos,
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
            'correo' => 'required|max:54|email',
            'clave'  => 'required|string|max:32',
            'pin'    => 'required|string|max:16'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }

        $correo = Correo::create([
            'correo' => $request->correo,
            'clave'  => $request->clave,
            'pin'    => $request->pin
        ]);

        if (!$correo) {
            $data = [
                'message' => 'Error al crear el correo',
                'status'  => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'correo' => $correo,
            'message' => 'Correo creado correctamente',
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $correo = Correo::find($id);
        if (!$correo) {
            $data = [
                'message' => 'Correo no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'correo' => $correo,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $correo = Correo::find($id);
        if (!$correo) {
            $data = [
                'message' => 'Correo no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(),[
            'correo' => 'required|string|max:54|email',
            'clave'  => 'required|string|max:32',
            'pin'    => 'required|string|max:16'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }

        $correo->update($request->only(['correo', 'clave', 'pin']));
        $data = [
            'correo' => $correo,
            'message' => 'Correo actualizado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $correo = Correo::find($id);
        if (!$correo) {
            $data = [
                'message' => 'Correo no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $correo->delete();
        $data = [
            'message' => 'Correo eliminado correctamente',
            'status'  => 200
        ];
        return response()->json($data, 200);
    }
}
