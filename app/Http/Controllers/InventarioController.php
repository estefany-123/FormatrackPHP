<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inventario\StoreInventarioRequest;
use App\Http\Requests\Inventario\UpdateInventarioRequest;
use App\Models\CodigoInventario;
use App\Models\Inventario;
use App\Services\NotificacionesService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InventarioController extends Controller
{
    protected NotificacionesService $notificacionesService;

    public function __construct(NotificacionesService $notificacionesService)
    {
        $this->notificacionesService = $notificacionesService;
    }

    public function index()
    {
        $inventarios = Inventario::with(['elemento','elemento.caracteristica', 'sitio', 'codigos'])->get();
        return response()->json($inventarios, 200);
    }

    public function show($id)
    {
        $inventario = Inventario::find($id);

        if (!$inventario) {
            return response()->json(['message' => 'No se encontró el inventario con ese id'], 404);
        }

        return response()->json($inventario, 200);
    }

    public function store(StoreInventarioRequest $request)
    {
        $data = $request->validated();

        $inventario = Inventario::create($data);

        return response()->json([
            'message' => 'Inventario creado correctamente',
            'data'    => $inventario,
        ], 201);
    }
    // Aquí recibe Request, valida y ejecuta agregar stock
    public function agregarStock(Request $request)
    {
        $data = $request->validate([
            'fk_elemento' => 'required|integer|exists:elementos,id_elemento',
            'fk_sitio' => 'required|integer|exists:sitios,id_sitio',
            'stock' => 'sometimes|integer|min:1',
            'codigos' => 'sometimes|array',
            'codigos.*' => 'string',
        ]);

        $inventario = Inventario::with('elemento.caracteristica')
            ->where('fk_elemento', $data['fk_elemento'])
            ->where('fk_sitio', $data['fk_sitio'])
            ->first();

        if (!$inventario) {
            return response()->json(['message' => 'Inventario no encontrado'], 404);
        }

        if (!$inventario->estado) {
            throw ValidationException::withMessages([
                'estado' => ['El inventario está inactivo. Actívelo para agregar stock.'],
            ]);
        }

        if ($inventario->elemento->caracteristica) {
            if (empty($data['codigos']) || count($data['codigos']) === 0) {
                throw ValidationException::withMessages([
                    'codigos' => ['Este elemento requiere códigos para agregar stock'],
                ]);
            }

            foreach ($data['codigos'] as $codigo) {
                if (CodigoInventario::where('codigo', $codigo)->exists()) {
                    throw ValidationException::withMessages([
                        'codigo' => ["El código '{$codigo}' ya está registrado"],
                    ]);
                }
                CodigoInventario::create([
                    'codigo' => $codigo,
                    'fk_inventario' => $inventario->id_inventario,
                ]);
            }
            $inventario->increment('stock', count($data['codigos']));
        } else {
            if (empty($data['stock']) || $data['stock'] <= 0) {
                throw ValidationException::withMessages([
                    'stock' => ['Debe especificar una cantidad válida para agregar stock'],
                ]);
            }
            $inventario->increment('stock', $data['stock']);
        }

        $this->notificacionesService->notificarStockBajo($inventario);

        if ($inventario->elemento->perecedero && $inventario->elemento->fecha_vencimiento) {
            $this->notificacionesService->notificarProximaCaducidad($inventario);
        }

        return response()->json(['message' => 'Stock actualizado correctamente']);
    }

    public function update(UpdateInventarioRequest $request, int $id)
    {
        $data = $request->validate([
            'stock' => 'required|integer|min:1',
            // otros campos que quieras permitir
        ]);

        $inventario = Inventario::with('elemento.caracteristica')->find($id);

        if (!$inventario) {
            return response()->json(['message' => 'Inventario no encontrado'], 404);
        }

        if (!$inventario->estado) {
            throw ValidationException::withMessages([
                'estado' => ['Este elemento está inactivo. Actívelo antes de agregar stock.'],
            ]);
        }

        if ($inventario->elemento->caracteristica) {
            throw ValidationException::withMessages([
                'codigos' => ['Este inventario requiere códigos. Use el método de agregar stock por códigos.'],
            ]);
        }

        $inventario->increment('stock', $data['stock']);

        $this->notificacionesService->notificarStockBajo($inventario);

        return response()->json($inventario);
    }

    public function destroy($id_inventario)
    {
        $inventario = Inventario::find($id_inventario);

        if (!$inventario || $inventario->estado === false) {
            if ($inventario) {
                $inventario->update(['estado' => true]);
                return response()->json(['message' => 'Inventario activado correctamente'], 200);
            }
            return response()->json(['message' => 'Inventario no encontrado'], 404);
        }

        $inventario->update(['estado' => false]);

        return response()->json(['message' => 'Inventario desactivado correctamente'], 200);
    }
}
