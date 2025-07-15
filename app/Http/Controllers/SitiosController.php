<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSitioRequest;
use App\Http\Requests\UpdateSitioRequest;
use App\Models\Sitios;
use Illuminate\Http\Request;

class SitiosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene todos los registros de la tabla "areas"
        $sitios = Sitios::all();

        // Retorna los datos en formato JSON con código HTTP 200 (OK)
        return response()->json($sitios, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSitioRequest $request)
    {
        // Crea una nueva área usando solo los datos validados por StoreAreaRequest
        $sitio = Sitios::create($request->validated());

        // Retorna la nueva área creada y el código HTTP 201 (creado)
        return response()->json($sitio, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Busca el área por ID (sin relaciones si no están definidas)
        $sitio = Sitios::find($id);

        // Si no existe o está inactiva, retorna error 404
        if (!$sitio || $sitio->estado === false) {
        }

        // Retorna el área encontrada en formato JSON
        return response()->json($sitio, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(UpdateSitioRequest $request, $id)
    {
        $sitio = Sitios::find($id);

        if (!$sitio || $sitio->estado === false) {
            return response()->json(['message' => 'sitio no encontrada o inactiva'], 404);
        }

        $sitio->update($request->validated());

        return response()->json($sitio, 200);
    }




    public function destroy($id)
    {
        $sitio = Sitios::find($id);

        if (!$sitio || $sitio->estado === false) {
            return response()->json(['message' => 'sitio no encontrada o ya inactiva'], 404);
        }

        $sitio->update(['estado' => false]);

        return response()->json(['message' => 'sitio desactivada correctamente'], 200);
    }
}
