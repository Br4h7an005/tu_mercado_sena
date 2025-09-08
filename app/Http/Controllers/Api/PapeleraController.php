<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Papelera;
class PapeleraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $papeleras = Papelera::all();
        $data = [
            'papeleras' => $papeleras,
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
            'mensaje'    => 'required|string|max:512',
            'es_imagen'      => 'boolean'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }
        $papelera = Papelera::create([
            'usuario_id' => $request->usuario_id,
            'mensaje'    => $request->mensaje,
            'es_imagen'      => $request->es_imagen 
        ]);
        if (!$papelera) {
            $data = [
                'message' => 'Error al crear el registro en la papelera',
                'status'  => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'papelera' => $papelera,
            'message' => 'Registro creado en la papelera exitosamente',
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $papelera = Papelera::find($id);
        if (!$papelera) {
            $data = [
                'message' => 'Registro en la papelera no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'papelera' => $papelera,
            'status'   => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $papelera = Papelera::find($id);
        if (!$papelera) {
            $data = [
                'message' => 'Registro en la papelera no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'usuario_id' => 'required|integer',
            'mensaje'    => 'required|string|max:512',
            'es_imagen'      => 'boolean'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }

        $papelera->update($request->only(['usuario_id', 'mensaje', 'es_imagen']));
        
        $data = [
            'papelera' => $papelera,
            'message' => 'Registro en la papelera actualizado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $papelera = Papelera::find($id);
        if (!$papelera) {
            $data = [
                'message' => 'Registro en la papelera no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        $papelera->delete();

        $data = [
            'message' => 'Registro en la papelera eliminado exitosamente',
            'status'  => 200
        ];
        return response()->json($data, 200);
    }
}
