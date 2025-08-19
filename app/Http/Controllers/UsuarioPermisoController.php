<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsuarioPermisoController extends Controller
{
     public function refetch()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $idUsuario = $user->id;

        $flatData = DB::table('users as u')
            ->join('roles as r', 'u.fk_rol', '=', 'r.id_rol')
            ->join('rol_permisos as rp', 'r.id_rol', '=', 'rp.fk_rol')
            ->join('permisos as p', 'rp.fk_permiso', '=', 'p.id_permiso')
            ->join('rutas as rt', 'p.fk_ruta', '=', 'rt.id_ruta')
            ->join('modulos as m', 'rt.fk_modulo', '=', 'm.id_modulo')
            ->where('u.id', $idUsuario)
            ->where('rp.estado', true)
            ->where('rt.estado', true)
            ->where('m.estado', true)
            ->where('r.estado', true)
            ->select([
                'm.id_modulo',
                'm.nombre as modulo_nombre',
                'm.icono as modulo_icono',
                'm.href as modulo_href',
                'rt.id_ruta',
                'rt.nombre as ruta_nombre',
                'rt.href as ruta_href',
                'rt.icono as ruta_icono',
                'rt.listed as ruta_listed',
                'p.id_permiso'
            ])
            ->get();

        // Agrupar igual que antes
        $grouped = [];
        foreach ($flatData as $row) {
            $moduloId = $row->id_modulo;

            if (!isset($grouped[$moduloId])) {
                $grouped[$moduloId] = [
                    'id' => $moduloId,
                    'nombre' => $row->modulo_nombre,
                    'icono' => $row->modulo_icono,
                    'href' => $row->modulo_href,
                    'rutas' => [],
                ];
            }

            $rutaId = $row->id_ruta;

            $rutaIndex = array_search($rutaId, array_column($grouped[$moduloId]['rutas'], 'id'));

            if ($rutaIndex === false) {
                $grouped[$moduloId]['rutas'][] = [
                    'id' => $rutaId,
                    'nombre' => $row->ruta_nombre,
                    'href' => $row->ruta_href,
                    'icono' => $row->ruta_icono,
                    'listed' => $row->ruta_listed,
                    'permisos' => [$row->id_permiso],
                ];
            } else {
                $grouped[$moduloId]['rutas'][$rutaIndex]['permisos'][] = $row->id_permiso;
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Permisos obtenidos correctamente',
            'modules' => array_values($grouped),
        ]);
    }
}
