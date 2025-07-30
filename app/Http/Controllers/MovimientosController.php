<?php

namespace App\Http\Controllers;

use App\Models\Movimientos;
use App\Models\Inventario;
use App\Models\CodigoInventario;
use App\Models\TiposMovimiento;
use App\Models\Notificacion;
use App\Models\Notificaciones;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Services\NotificacionService;

class MovimientoController extends Controller
{
    protected $notificacionService;

    public function __construct(Notificaciones $notificacion)
    {
        $this->notificacionService = $notificacion;
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->all();

            $inventario = Inventario::with('elemento.caracteristica', 'sitio')
                ->find($data['fk_inventario']);

            if (!$inventario) {
                throw new NotFoundHttpException('Inventario no encontrado');
            }

            $tipo = TiposMovimiento::find($data['fk_tipo_movimiento']);
            if (!$tipo) {
                throw new NotFoundHttpException('Tipo de movimiento inválido');
            }

            $tieneCaracteristicas = !is_null($inventario->elemento?->caracteristica);
            $nombreTipo = strtolower($tipo->nombre);

            // === Con características ===
            if ($tieneCaracteristicas) {
                if (in_array($nombreTipo, ['salida', 'baja', 'prestamo'])) {
                    if (empty($data['codigos'])) {
                        throw ValidationException::withMessages([
                            'codigos' => 'Debe especificar códigos para este movimiento'
                        ]);
                    }

                    $codigosDisponibles = CodigoInventario::where('fk_inventario', $inventario->id)
                        ->where('uso', false)
                        ->pluck('codigo')
                        ->toArray();

                    $faltantes = array_diff($data['codigos'], $codigosDisponibles);
                    if (count($faltantes) > 0) {
                        throw ValidationException::withMessages([
                            'codigos' => 'Códigos no disponibles: ' . implode(', ', $faltantes)
                        ]);
                    }

                    CodigoInventario::whereIn('codigo', $data['codigos'])
                        ->where('fk_inventario', $inventario->id)
                        ->update(['uso' => true]);

                    $inventario->stock -= count($data['codigos']);
                } elseif ($nombreTipo === 'ingreso') {
                    if (empty($data['codigos'])) {
                        throw ValidationException::withMessages([
                            'codigos' => 'Debe especificar códigos para este movimiento'
                        ]);
                    }

                    foreach ($data['codigos'] as $codigo) {
                        CodigoInventario::create([
                            'codigo' => $codigo,
                            'fk_inventario' => $inventario->id,
                            'uso' => false,
                        ]);
                    }

                    $inventario->stock += count($data['codigos']);
                }
            }
            // === Sin características ===
            else {
                if (in_array($nombreTipo, ['salida', 'baja', 'prestamo'])) {
                    if (empty($data['cantidad']) || $data['cantidad'] <= 0) {
                        throw ValidationException::withMessages([
                            'cantidad' => 'Debe indicar una cantidad válida'
                        ]);
                    }
                    if ($data['cantidad'] > $inventario->stock) {
                        throw ValidationException::withMessages([
                            'cantidad' => 'No hay suficiente stock disponible'
                        ]);
                    }

                    $inventario->stock -= $data['cantidad'];
                } elseif (in_array($nombreTipo, ['ingreso', 'devolucion'])) {
                    if (empty($data['cantidad']) || $data['cantidad'] <= 0) {
                        throw ValidationException::withMessages([
                            'cantidad' => 'Debe indicar una cantidad válida'
                        ]);
                    }

                    $inventario->stock += $data['cantidad'];
                }
            }

            $inventario->save();

            $movimiento = Movimientos::create([
                'fk_inventario' => $inventario->id,
                'fk_tipo_movimiento' => $tipo->id,
                'cantidad' => $data['cantidad'] ?? count($data['codigos'] ?? []),
                'descripcion' => $data['descripcion'] ?? null,
                'fk_usuario' => $request->user()->id ?? $data['fk_usuario'],
                'fk_sitio' => $data['fk_sitio'],
                'en_proceso' => true,
                'aceptado' => false,
                'cancelado' => false,
                'hora_ingreso' => $data['hora_ingreso'] ?? null,
                'hora_salida' => $data['hora_salida'] ?? null,
                'fecha_devolucion' => $data['fecha_devolucion'] ?? null,
                'devolutivo' => $data['devolutivo'] ?? null,
                'no_devolutivo' => $data['no_devolutivo'] ?? null,
                'lugar_destino' => $data['lugar_destino'] ?? null,
            ]);

            $usuario = User::with('rol')->find($request->user()->id ?? $data['fk_usuario']);

            // Notificaciones
            $this->notificacionService->notificarMovimientoPendiente($movimiento, $usuario, $inventario);
            $this->notificacionService->notificarIngreso($movimiento, $usuario, $inventario);
            $this->notificacionService->notificarStockBajo($inventario);

            return response()->json($movimiento, 201);
        });
    }

    public function index()
    {
        return Movimientos::with(['inventario.elemento', 'sitio', 'tiposMovimiento', 'usuario'])->get();
    }

    public function show($id)
    {
        $movimiento = Movimientos::find($id);
        if (!$movimiento) {
            abort(404, 'Movimientos no encontrado');
        }
        return $movimiento;
    }

    public function update(Request $request, $id)
    {
        $movimiento = Movimientos::findOrFail($id);

        $movimiento->update($request->only([
            'hora_ingreso',
            'hora_salida',
            'descripcion',
            'cantidad',
            'fecha_devolucion',
        ]));

        return response()->json($movimiento);
    }

    public function accept($id)
    {
        $movimiento = Movimientos::findOrFail($id);

        if (!$movimiento->en_proceso) {
            return response()->json(['error' => 'Este movimiento ya fue gestionado'], 400);
        }

        $movimiento->update([
            'en_proceso' => false,
            'aceptado' => true,
            'cancelado' => false,
        ]);

        Notificaciones::whereJsonContains('data->idMovimiento', $id)
            ->update(['estado' => 'aceptado']);

        return response()->json($movimiento);
    }

    public function cancel($id)
    {
        $movimiento = Movimientos::findOrFail($id);

        if (!$movimiento->en_proceso) {
            return response()->json(['error' => 'Este movimiento ya fue gestionado'], 400);
        }

        $movimiento->update([
            'en_proceso' => false,
            'aceptado' => false,
            'cancelado' => true,
        ]);

        Notificaciones::whereJsonContains('data->idMovimiento', $id)
            ->update(['estado' => 'cancelado']);

        return response()->json($movimiento);
    }
}
