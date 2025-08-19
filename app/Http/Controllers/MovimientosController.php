<?php

namespace App\Http\Controllers;

use App\Http\Requests\Movimientos\StoreMovimientoRequest;
use App\Http\Requests\Movimientos\UpdateMovimientoRequest;
use App\Models\Inventario;
use App\Models\CodigoInventario;
use App\Models\Movimientos;
use App\Models\Notificaciones;
use App\Models\TiposMovimientos;
use App\Models\User;
use App\Services\NotificacionesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class MovimientosController extends Controller
{
    protected NotificacionesService $notificacionesService;

    public function __construct(NotificacionesService $notificacionesService)
    {
        $this->notificacionesService = $notificacionesService;
    }

    // Listar todos los movimientos
    public function index(): JsonResponse
    {
        $movimientos = Movimientos::with([
            'inventario.elemento.caracteristica',
            'sitio',
            'tipoMovimiento',
            'usuario.rol',
            'inventario.codigos'
        ])->get();

        return response()->json($movimientos);
    }

    // Crear movimiento
public function store(StoreMovimientoRequest $request): JsonResponse
{
    $data = $request->validated();
    $idUsuario = $request->user()?->id;

    if (!$idUsuario) {
        return response()->json(['error' => 'Usuario no autenticado'], 401);
    }

    DB::beginTransaction();

    try {
        $inventario = Inventario::with('elemento.caracteristica', 'sitio')->findOrFail($data['fk_inventario']);
        $tipoMovimiento = TiposMovimientos::findOrFail($data['fk_tipo_movimiento']);
        $usuario = User::with('rol')->findOrFail($idUsuario);

        $tieneCaracteristicas = $inventario->elemento && !is_null($inventario->elemento->caracteristica);
        $nombreTipo = strtolower($tipoMovimiento->nombre);
        $codigos = $data['codigos'] ?? [];
        $cantidad = $data['cantidad'] ?? 0;

        // --- Lógica para movimientos con características ---
        if ($tieneCaracteristicas) {
            if (in_array($nombreTipo, ['salida', 'baja', 'prestamo'])) {
                if (empty($codigos)) {
                    throw ValidationException::withMessages(['codigos' => 'Debe especificar códigos para este movimiento']);
                }

                $codigosDisponibles = CodigoInventario::where('fk_inventario', $inventario->id_inventario)
                    ->where('uso', false)
                    ->pluck('codigo')
                    ->toArray();

                $faltantes = array_diff($codigos, $codigosDisponibles);
                if (!empty($faltantes)) {
                    throw ValidationException::withMessages(['codigos' => 'Estos códigos no están disponibles: ' . implode(', ', $faltantes)]);
                }

                CodigoInventario::where('fk_inventario', $inventario->id_inventario)
                    ->whereIn('codigo', $codigos)
                    ->update(['uso' => true]);

                $inventario->stock -= count($codigos);

            } elseif ($nombreTipo === 'ingreso') {
                if (empty($codigos)) {
                    throw ValidationException::withMessages(['codigos' => 'Debe especificar códigos para este movimiento']);
                }

                $codigosExistentes = CodigoInventario::where('fk_inventario', $inventario->id_inventario)
                    ->whereIn('codigo', $codigos)
                    ->pluck('codigo')
                    ->toArray();

                if (!empty($codigosExistentes)) {
                    throw ValidationException::withMessages([
                        'codigos' => 'Los siguientes códigos ya existen en el inventario: ' . implode(', ', $codigosExistentes)
                    ]);
                }

                foreach ($codigos as $codigo) {
                    CodigoInventario::create([
                        'codigo' => $codigo,
                        'fk_inventario' => $inventario->id_inventario,
                        'uso' => false,
                    ]);
                }

                $inventario->stock += count($codigos);

            } elseif ($nombreTipo === 'devolucion') {
                if (empty($codigos)) {
                    throw ValidationException::withMessages(['codigos' => 'Debe especificar códigos para devolver']);
                }

                $codigosEnUso = CodigoInventario::where('fk_inventario', $inventario->id_inventario)
                    ->where('uso', true)
                    ->pluck('codigo')
                    ->toArray();

                $noPrestados = array_diff($codigos, $codigosEnUso);
                if (!empty($noPrestados)) {
                    throw ValidationException::withMessages([
                        'codigos' => 'Estos códigos no están en préstamo: ' . implode(', ', $noPrestados)
                    ]);
                }

                CodigoInventario::where('fk_inventario', $inventario->id_inventario)
                    ->whereIn('codigo', $codigos)
                    ->update(['uso' => false]);

                $inventario->stock += count($codigos);
            }

        // --- Lógica para movimientos sin características ---
        } else {
            if (in_array($nombreTipo, ['salida', 'baja', 'prestamo'])) {
                if ($cantidad <= 0) {
                    throw ValidationException::withMessages(['cantidad' => 'Debe indicar cantidad válida']);
                }
                if ($cantidad > $inventario->stock) {
                    throw ValidationException::withMessages(['cantidad' => 'No hay suficiente stock']);
                }
                $inventario->stock -= $cantidad;

            } elseif (in_array($nombreTipo, ['ingreso', 'devolucion'])) {
                if ($cantidad <= 0) {
                    throw ValidationException::withMessages(['cantidad' => 'Debe indicar cantidad válida']);
                }
                $inventario->stock += $cantidad;
            }
        }

        $inventario->save();

        $esIngreso = $nombreTipo === 'ingreso';

        $movimiento = Movimientos::create([
            'fk_inventario' => $inventario->id_inventario,
            'fk_tipo_movimiento' => $tipoMovimiento->id_tipo,
            'cantidad' => $tieneCaracteristicas ? count($codigos) : $cantidad,
            'descripcion' => $data['descripcion'] ?? null,
            'fk_usuario' => $idUsuario,
            'fk_sitio' => $data['fk_sitio'],
            'en_proceso' => !$esIngreso,
            'aceptado' => $esIngreso,
            'cancelado' => false,
            'hora_ingreso' => $data['hora_ingreso'] ?? null,
            'hora_salida' => $data['hora_salida'] ?? null,
            'fecha_devolucion' => $data['fecha_devolucion'] ?? null,
            'devolutivo' => $data['devolutivo'] ?? null,
            'no_devolutivo' => $data['no_devolutivo'] ?? null,
            'lugar_destino' => $data['lugar_destino'] ?? null,
        ]);

        $movimiento->load(['tipoMovimiento', 'usuario', 'inventario.elemento', 'sitio']);

        // --- Notificaciones ---
        $this->notificacionesService->notificarMovimientoPendiente([
            'idMovimiento' => $movimiento->id,
            'tipo' => $tipoMovimiento,
            'usuario' => $usuario,
            'sitio' => ['id' => $data['fk_sitio'], 'nombre' => $inventario->sitio->nombre ?? 'Sitio'],
        ]);

        $this->notificacionesService->notificarIngreso([
            'id' => $movimiento->id,
            'tipo' => $tipoMovimiento,
            'cantidad' => $movimiento->cantidad,
            'elemento' => $inventario->elemento,
            'usuario' => $usuario,
            'sitio' => ['id' => $data['fk_sitio'], 'nombre' => $inventario->sitio->nombre ?? 'Sitio'],
        ]);

        if ($nombreTipo === 'prestamo') {
            $this->notificacionesService->notificarPrestamoConDevolucion([
                'movimiento' => $movimiento,
                'usuario' => $usuario,
                'elemento' => $inventario->elemento,
            ]);
        }

        DB::commit();

        return response()->json($movimiento, Response::HTTP_CREATED);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => config('app.debug') ? $e->getTrace() : null,
        ], Response::HTTP_BAD_REQUEST);
    }
}



    // Mostrar un movimiento
    public function show(int $id): JsonResponse
    {
        $movimiento = Movimientos::with(['inventario', 'sitio', 'tiposMovimientos', 'usuario'])->find($id);

        if (!$movimiento) {
            return response()->json(['message' => 'Movimiento no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($movimiento);
    }

    // Actualizar movimiento
    public function update(UpdateMovimientoRequest $request, int $id): JsonResponse
    {
        $movimiento = Movimientos::find($id);

        if (!$movimiento) {
            return response()->json(['message' => 'Movimiento no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->validated();

        $movimiento->update($data);

        return response()->json($movimiento);
    }

    // Aceptar movimiento pendiente
    public function accept(int $id): JsonResponse
    {
        $movimiento = Movimientos::find($id);

        if (!$movimiento) {
            return response()->json(['message' => "El movimiento con id {$id} no existe"], Response::HTTP_NOT_FOUND);
        }

        if (!$movimiento->en_proceso) {
            return response()->json(['message' => 'Este movimiento ya fue gestionado'], Response::HTTP_BAD_REQUEST);
        }

        $movimiento->aceptado = true;
        $movimiento->en_proceso = false;
        $movimiento->cancelado = false;
        $movimiento->save();

        Notificaciones::where('data->idMovimiento', $movimiento->id)
            ->update(['estado' => 'aceptado']);

        $this->notificacionesService->notificarMovimientoAceptado($movimiento);

        return response()->json($movimiento);
    }

    // Cancelar movimiento pendiente
    public function cancel(int $id): JsonResponse
    {
        $movimiento = Movimientos::find($id);

        if (!$movimiento) {
            return response()->json(['message' => "El movimiento con id {$id} no existe"], Response::HTTP_NOT_FOUND);
        }

        if (!$movimiento->en_proceso) {
            return response()->json(['message' => 'Este movimiento ya fue gestionado'], Response::HTTP_BAD_REQUEST);
        }

        $movimiento->aceptado = false;
        $movimiento->en_proceso = false;
        $movimiento->cancelado = true;
        $movimiento->save();

        Notificaciones::where('data->idMovimiento', $movimiento->id)
            ->update(['estado' => 'cancelado']);

        return response()->json($movimiento);
    }

    // Obtener códigos disponibles para devolver (método extra)
    public function codigosDisponiblesParaDevolver(int $idInventario): JsonResponse
    {
        $codigosEnUso = CodigoInventario::where('fk_inventario', $idInventario)
            ->where('uso', true)
            ->pluck('codigo');

        return response()->json($codigosEnUso);
    }
}
