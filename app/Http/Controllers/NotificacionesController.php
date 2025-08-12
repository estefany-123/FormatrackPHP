<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notificaciones\CreateNotificacionRequest;
use App\Http\Requests\Notificaciones\UpdateNotificacionRequest;
use App\Models\Notificaciones;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    // Listar todas con usuario
    public function index()
    {
        $notificaciones = Notificaciones::with('usuario')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($notificaciones);
    }

    // Obtener por usuario, filtrando segun lógica inventario (simplificada)
    public function getPorUsuario($idUsuario)
    {
        $notificaciones = Notificaciones::where('fk_usuario', $idUsuario)
            ->orderByDesc('created_at')
            ->get();

        // Para simplificar, sin lógica inventario, solo devuelvo todas
        return response()->json($notificaciones);
    }

    // Crear notificación
    public function store(CreateNotificacionRequest $request)
    {
        $data = $request->validated();

        // Parse JSON string a array si viene como string
        if (isset($data['data']) && is_string($data['data'])) {
            $data['data'] = json_decode($data['data'], true);
        }

        $notificacion = Notificaciones::create($data);

        // Aquí deberías emitir WebSocket si usas, o eventos

        return response()->json($notificacion, 201);
    }

    // Mostrar una notificación
    public function show($id)
    {
        $notificacion = Notificaciones::with('usuario')->findOrFail($id);
        return response()->json($notificacion);
    }

    // Actualizar
    public function update(UpdateNotificacionRequest $request, $id)
    {
        $notificacion = Notificaciones::findOrFail($id);

        $data = $request->validated();

        if (isset($data['data']) && is_string($data['data'])) {
            $data['data'] = json_decode($data['data'], true);
        }

        $notificacion->update($data);

        return response()->json($notificacion);
    }

    // Marcar como leído
    public function marcarComoLeida($id)
    {
        $notificacion = Notificaciones::findOrFail($id);
        $notificacion->leido = true;
        $notificacion->save();

        return response()->json($notificacion);
    }

    // Cambiar estado (aceptado/cancelado)
    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:aceptado,cancelado',
        ]);

        $notificacion = Notificaciones::findOrFail($id);

        if (!$notificacion->requiere_accion) {
            return response()->json(['error' => 'Esta notificación no requiere acción'], 422);
        }

        $notificacion->estado = $request->estado;
        $notificacion->leido = true;
        $notificacion->save();

        return response()->json($notificacion);
    }

    // Eliminar notificación
    public function destroy($id)
    {
        $notificacion = Notificaciones::findOrFail($id);
        $notificacion->delete();

        return response()->json(['message' => 'Notificación eliminada']);
    }
}
