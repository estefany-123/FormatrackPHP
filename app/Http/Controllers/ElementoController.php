<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreElementoRequest;
use App\Http\Requests\UpdateElementoRequest;
use App\Models\Elementos;
use App\Models\Inventario;
use App\Models\Sitios;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ElementoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        // Obtiene todos los registros de la tabla "areas"
        $elemento = Elementos::all();

        // Retorna los datos en formato JSON con código HTTP 200 (OK)
        return response()->json($elemento, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
public function store(StoreElementoRequest $request)
{
    return DB::transaction(function () use ($request) {
        $data = $request->validated();

        if ($request->hasFile('imagen_elemento')) {
            $archivo = $request->file('imagen_elemento');
            $nombreImagen = Str::random(20) . '.' . $archivo->getClientOriginalExtension();
            $archivo->storeAs('public/img', $nombreImagen);
            $data['imagen_elemento'] = 'storage/img/' . $nombreImagen;
        } else {
            $data['imagen_elemento'] = 'storage/img/defaultPerfil.png';
        }

        $elemento = Elementos::create($data);

        $sitios = Sitios::all();
        foreach ($sitios as $sitio) {
            Inventario::create([
                'fk_elemento' => $elemento->id_elemento,
                'fk_sitio' => $sitio->id_sitio,
                'stock' => 0,
                'estado' => false,
            ]);
        }

        return response()->json([
            'message' => 'Elemento creado con éxito.',
            'data' => $elemento,
        ], 201);
    });
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Busca el área por ID (sin relaciones si no están definidas)
        $elemento = Elementos::find($id);

        // Si no existe o está inactiva, retorna error 404
        if (!$elemento || $elemento->estado === false) {
        }

        // Retorna el área encontrada en formato JSON
        return response()->json($elemento, 200);
    }

    /**
     * Update the specified resource in storage.
     */
public function update(UpdateElementoRequest $request, $id)
{
    return DB::transaction(function () use ($request, $id) {
        $data = $request->validated();
        $elemento = Elementos::findOrFail($id);

        // Si hay nueva imagen_elemento, reemplazar la anterior
        if ($request->hasFile('imagen_elemento')) {
            if ($elemento->imagen_elemento !== 'storage/img/defaultPerfil.png') {
                Storage::delete(str_replace('storage/', 'public/', $elemento->imagen_elemento));
            }

            $archivo = $request->file('imagen_elemento');
            $nombreImagen = Str::random(20) . '.' . $archivo->getClientOriginalExtension();
            $archivo->storeAs('public/img', $nombreImagen);
            $data['imagen_elemento'] = 'storage/img/' . $nombreImagen;
        }

        $elemento->update($data);

        return response()->json([
            'message' => 'Elemento actualizado correctamente.',
            'data' => $elemento,
        ]);
    });
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $elemento = Elementos::find($id);

        if (!$elemento || $elemento->estado === false) {
            return response()->json(['message' => 'elemento no encontrada o ya inactiva'], 404);
        }

        $elemento->update(['estado' => false]);

        return response()->json(['message' => 'elemento desactivada correctamente'], 200);
    }
}
