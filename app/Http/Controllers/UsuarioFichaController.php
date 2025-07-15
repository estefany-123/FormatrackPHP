<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioFichaRequest;
use App\Http\Requests\UpdateUsuarioFichaRequest;
use App\Models\UsuarioFicha;
use Illuminate\Http\Request;

class UsuarioFichaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene todos los registros de la tabla "areas"
        $UsuarioFichas = UsuarioFicha::all();

        // Retorna los datos en formato JSON con código HTTP 200 (OK)
        return response()->json($UsuarioFichas, 200);
    }
    /**

     * Store a newly created resource in storage.
     */
    public function store(StoreUsuarioFichaRequest $request)
    {
        // Crea una nueva área usando solo los datos validados por StoreAreaRequest
        $UsuarioFichas = UsuarioFicha::create($request->validated());

        // Retorna la nueva área creada y el código HTTP 201 (creado)
        return response()->json($UsuarioFichas, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Busca el área por ID (sin relaciones si no están definidas)
        $UsuarioFichas = UsuarioFicha::find($id);

        // Si no existe o está inactiva, retorna error 404
        if (!$UsuarioFichas || $UsuarioFichas->estado === false) {
        }

        // Retorna el área encontrada en formato JSON
        return response()->json($UsuarioFichas, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(UpdateUsuarioFichaRequest $request, $id)
    {
        $UsuarioFichas = UsuarioFicha::find($id);

        if (!$UsuarioFichas || $UsuarioFichas->estado === false) {
            return response()->json(['message' => 'UsuarioFichas no encontrada o inactiva'], 404);
        }

        $UsuarioFichas->update($request->validated());

        return response()->json($UsuarioFichas, 200);
    }
}
