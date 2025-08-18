<?php

namespace App\Http\Controllers;

use App\Http\Requests\Elementos\StoreElementoRequest;
use App\Http\Requests\Elementos\UpdateElementoRequest;
use App\Models\Elementos;
use App\Models\Inventario;
use App\Models\Sitios;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
    public function store(StoreElementoRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();

                // ✅ Manejo de la imagen
                if ($request->hasFile('imagen_elemento')) {
                    $archivo = $request->file('imagen_elemento');
                    $nombreImagen = Str::random(20) . '.' . $archivo->getClientOriginalExtension();
                    $archivo->move(public_path('img'), $nombreImagen); // directamente en public/img
                    $data['imagen_elemento'] = 'img/' . $nombreImagen;
                } else {
                    $data['imagen_elemento'] = 'storage/img/defaultPerfil.png';
                }

                $elemento = Elementos::create($data);

                // ✅ Asignaciones de inventario
                $sitios = Sitios::all();
                $asignaciones = $sitios->map(function ($sitio) use ($elemento) {
                    return [
                        'fk_elemento' => $elemento->id_elemento,
                        'fk_sitio' => $sitio->id_sitio,
                        'stock' => 0,
                        'estado' => false,
                    ];
                })->toArray();

                Inventario::insert($asignaciones);

                return response()->json([
                    'message' => 'Elemento creado con éxito.',
                    'data' => $elemento,
                    'id_elemento' => $elemento->id_elemento,
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el elemento: ' . $e->getMessage(),
            ], 500);
        }
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
        try {
            return DB::transaction(function () use ($request, $id) {
                $data = $request->validated();
                $elemento = Elementos::findOrFail($id);

                // ✅ Manejo de la imagen
                if ($request->hasFile('imagen_elemento')) {
                    if ($elemento->imagen_elemento && $elemento->imagen_elemento !== 'storage/img/defaultPerfil.png') {
                        Storage::delete(str_replace('storage/', 'public/', $elemento->imagen_elemento));
                    }

                    $archivo = $request->file('imagen_elemento');
                    $nombreImagen = Str::random(20) . '.' . $archivo->getClientOriginalExtension();
                    $archivo->storeAs('public/img', $nombreImagen);
                    $data['imagen_elemento'] = 'storage/img/' . $nombreImagen;
                }

                // ✅ Verificar cambios reales
                $cambios = array_diff_assoc($data, $elemento->getAttributes());

                if (empty($cambios)) {
                    return response()->json([
                        'message' => 'No se detectaron cambios en el elemento'
                    ], 200);
                }

                $elemento->update($data);
                $elemento->refresh();

                return response()->json([
                    'message' => 'Elemento actualizado correctamente.',
                    'cambios' => $cambios,
                    'elemento' => $elemento,
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar elemento',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $elemento = Elementos::find($id);

        if (!$elemento || $elemento->estado === false) {
            $elemento->update(['estado' => true]);
            return response()->json(['message' => 'elemento activado con exito'], 200);
        }

        $elemento->update(['estado' => false]);

        return response()->json(['message' => 'elemento desactivada correctamente'], 200);
    }
}
