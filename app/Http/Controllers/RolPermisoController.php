<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRolPermisoRequest;
use App\Http\Requests\UpdateRolPermisoRequest;
use App\Models\Permisos;
use App\Models\RolPermiso;
use Illuminate\Http\Request;

class RolPermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rolpermiso = RolPermiso::all();

        // Retorna los datos en formato JSON con código HTTP 200 (OK)
        return response()->json($rolpermiso, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRolPermisoRequest $request)
    {
        $rolpermiso = RolPermiso::create($request->validated());

        return response()->json($rolpermiso, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rolpermiso = RolPermiso::find($id);

        // Si no existe o está inactiva, retorna error 404


        // Retorna el área encontrada en formato JSON
        return response()->json($rolpermiso, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRolPermisoRequest $request, $id)
    {
        $rolpermiso = RolPermiso::find($id);

        if (!$rolpermiso || $rolpermiso->estado === false) {
            return response()->json(['message' => 'rolpermiso no encontrada o inactiva'], 404);
        }

        $rolpermiso->update($request->validated());

        return response()->json($rolpermiso, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function changeStatus($idPermiso, $idRol)
    {
        // Buscar si ya existe el rol_permiso
        $rolPermiso = RolPermiso::where('fk_permiso', $idPermiso)
            ->where('fk_rol', $idRol)
            ->first();

        if (!$rolPermiso) {
            // Si no existe, lo creamos con estado = true
            $rolPermiso = RolPermiso::create([
                'fk_permiso' => $idPermiso,
                'fk_rol'     => $idRol,
                'estado'     => true,
            ]);
        } else {
            // Si existe, alternamos el estado
            $rolPermiso->estado = !$rolPermiso->estado;
            $rolPermiso->save();
        }

        return response()->json($rolPermiso);
    }


    public function getPermisosRol($idRol)
    {
        // 1) Todos los permisos con ruta y módulo
        $permisos = \App\Models\Permisos::with(['ruta.modulo'])->get();

        // 2) Permisos asignados al rol (solo activos)
        $rolPermisos = \App\Models\RolPermiso::with('permiso')
            ->where('fk_rol', $idRol)
            ->where('estado', true)
            ->get();

        $permisosAsignados = $rolPermisos->pluck('permiso.id_permiso')->all();

        // 3) Construir estructura agrupada (sin campo "asignado")
        $modulosMap = [];

        foreach ($permisos as $permiso) {
            $ruta = $permiso->ruta;
            if (!$ruta || !$ruta->modulo) {
                continue;
            }
            $modulo = $ruta->modulo;

            if (!isset($modulosMap[$modulo->id_modulo])) {
                $modulosMap[$modulo->id_modulo] = [
                    'idModulo'      => $modulo->id_modulo,
                    'nombreModulo'  => $modulo->nombre,
                    'rutas'         => []
                ];
            }

            if (!isset($modulosMap[$modulo->id_modulo]['rutas'][$ruta->id_ruta])) {
                $modulosMap[$modulo->id_modulo]['rutas'][$ruta->id_ruta] = [
                    'idRuta'     => $ruta->id_ruta,
                    'nombreRuta' => $ruta->nombre,
                    'permisos'   => []
                ];
            }

            $modulosMap[$modulo->id_modulo]['rutas'][$ruta->id_ruta]['permisos'][] = [
                'idPermiso' => $permiso->id_permiso,
                'permiso'   => $permiso->permiso,
            ];
        }

        // 4) Pasar maps a arrays planos
        $permisosAgrupados = array_values(array_map(function ($modulo) {
            $modulo['rutas'] = array_values($modulo['rutas']);
            return $modulo;
        }, $modulosMap));

        // 5) Respuesta igual que en NestJS
        return response()->json([
            'permisosAsignados' => $permisosAsignados,
            'permisosAgrupados' => $permisosAgrupados
        ], 200);
    }
}
