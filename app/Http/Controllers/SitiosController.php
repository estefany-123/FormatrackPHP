<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSitioRequest;
use App\Http\Requests\UpdateSitioRequest;
use App\Models\Elementos;
use App\Models\Inventario;
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
        // Crear el sitio con los datos validados
        $sitio = Sitios::create([
            ...$request->validated(),
            'fk_area' => $request->fk_area,
            'fk_tipo_sitio' => $request->fk_tipo_sitio,
        ]);

        // Obtener todos los elementos
        $elementos = Elementos::all();

        // Crear asignaciones de inventario para cada elemento
        $asignaciones = $elementos->map(function ($elemento) use ($sitio) {
            return [
                'fk_sitio' => $sitio->id_sitio,
                'fk_elemento' => $elemento->id_elemento,
                'stock' => 0,
                'estado' => false,
            ];
        })->toArray();

        // Guardar las asignaciones en la tabla de inventario
        Inventario::insert($asignaciones);

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



        public function updateState($id)
    {
        $sitio = Sitios::find($id);

        if (!$sitio) {
            return response()->json(['message' => 'sitio no encontrado'], 404);
        }

        $sitio->update(['estado' => !$sitio->estado]);

        return response()->json($sitio, 200);
    }
}
