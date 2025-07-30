<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventarioRequest;
use App\Http\Requests\UpdateInventarioRequest;
use App\Models\CodigoInventario;
use App\Models\Inventario;
use Dotenv\Store\StoreBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventario = Inventario::all();
        return response()->json($inventario, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function agregarStock(Request $request)
    {
        $request->validate([
            'fk_elemento' => 'required|exists:elementos,id_elemento',
            'fk_sitio' => 'required|exists:sitios,id_sitio',
            'codigos' => 'nullable|array',
            'codigos.*' => 'string'
        ]);

        return DB::transaction(function () use ($request) {
            $inventario = Inventario::with('fkElemento.fkCaracteristica', 'fkSitio')
                ->where('fk_elemento', $request->fk_elemento)
                ->where('fk_sitio', $request->fk_sitio)
                ->first();

            if (!$inventario) {
                return response()->json(['error' => 'Inventario no encontrado'], 404);
            }

            $elemento = $inventario->fkElemento;

            if ($elemento->fkCaracteristica) {
                if (!$request->filled('codigos') || count($request->codigos) === 0) {
                    return response()->json([
                        'error' => 'Este elemento requiere códigos para agregar stock'
                    ], 400);
                }

                foreach ($request->codigos as $codigo) {
                    CodigoInventario::create([
                        'codigo' => $codigo,
                        'fk_inventario' => $inventario->id_inventario,
                    ]);
                }

                $inventario->stock += count($request->codigos);
            } else {
                if (!$request->has('stock') || $request->stock <= 0) {
                    return response()->json([
                        'error' => 'Debe proporcionar una cantidad válida de stock'
                    ], 400);
                }

                $inventario->stock += $request->stock;
            }

            $inventario->save();

            // // Notificaciones
            // app(NotificacionService::class)->notificarStockBajo($inventario);

            // if ($elemento->perecedero && $elemento->fecha_vencimiento) {
            //     app(NotificacionService::class)->notificarProximaCaducidad([
            //         'elemento' => $elemento,
            //         'fecha_caducidad' => $elemento->fecha_vencimiento,
            //     ]);
            // }

            return response()->json([
                'message' => 'Stock actualizado correctamente',
                'stock' => $inventario->stock,
            ]);
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventarioRequest $request)
    {
        // Crea una nueva área usando solo los datos validados por StoreAreaRequest
        $inventario = Inventario::create($request->validated());

        // Retorna la nueva área creada y el código HTTP 201 (creado)
        return response()->json($inventario, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inventario = Inventario::find($id);

        if (!$inventario) {
            return response()->json(['message' => 'No se encontro el inventario con ese id'], 404);
        }

        return response()->json($inventario, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventario $inventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
public function update(UpdateInventarioRequest $request, $id)
{
    $inventario = Inventario::with('fkElemento.fkCaracteristica')->find($id);

    if (!$inventario || $inventario->estado === false) {
        return response()->json(['message' => 'Inventario no encontrado o inactivo'], 404);
    }

    // Verifica si el elemento tiene características (requiere códigos)
    if ($inventario->fkElemento && $inventario->fkElemento->fkCaracteristica) {
        return response()->json([
            'message' => 'Este inventario requiere códigos. Use el método de agregar stock por códigos.'
        ], 400);
    }

    // Valida que el stock a agregar sea válido
    if (!$request->has('stock') || $request->stock <= 0) {
        return response()->json([
            'message' => 'La cantidad debe ser mayor a 0.'
        ], 400);
    }

    // Actualiza el stock sumando el valor recibido
    $inventario->stock += $request->stock;
    $inventario->save();

    // Notificaciones (descomenta cuando tengas el servicio)
    // app(NotificacionService::class)->notificarStockBajo($inventario);
    // if ($inventario->fkElemento->perecedero && $inventario->fkElemento->fecha_vencimiento) {
    //     app(NotificacionService::class)->notificarProximaCaducidad([
    //         'elemento' => $inventario->fkElemento,
    //         'fecha_caducidad' => $inventario->fkElemento->fecha_vencimiento,
    //     ]);
    // }

    return response()->json([
        'message' => 'Inventario actualizado correctamente',
        'stock' => $inventario->stock,
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inventario = Inventario::find($id);

        if (!$inventario || $inventario->estado === false) {
            return response()->json(['message' => 'inventario no encontrado o ya inactiva'], 404);
        }

        $inventario->update(['estado' => false]);

        return response()->json(['message' => 'inventario desactivado correctamente'], 200);
    }
}
