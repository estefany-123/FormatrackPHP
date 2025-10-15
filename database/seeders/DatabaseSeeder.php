<?php

namespace Database\Seeders;

use App\Models\Modulos;
use App\Models\Permisos;
use App\Models\Roles;
use App\Models\RolPermiso;
use App\Models\Rutas;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $roles = [
            ['id_rol' => 1, 'nombre' => 'Administrador', 'estado' => true],
            ['id_rol' => 2, 'nombre' => 'Aprendiz', 'estado' => true],
        ];
        foreach ($roles as $rol) {
            Roles::create($rol);
        }

        User::create([
            'documento' => '1111111111',
            'nombre' => 'admin',
            'apellido' => 'account',
            'estado' => 'true',
            'password' => Hash::make('hola1234'),
            'fk_rol' => '1',
        ]);



        $modulos = [
            ['id_modulo' => 1, 'nombre' => 'Admin', 'icono' => 'UserIcon', 'estado' => true],
            ['id_modulo' => 2, 'nombre' => 'Bodega', 'icono' => 'ArchiveBoxIcon', 'estado' => true],
            ['id_modulo' => 3, 'nombre' => 'Reportes', 'icono' => 'DocumentChartBarIcon', 'estado' => true],
        ];
        foreach ($modulos as $mod) {
            Modulos::create($mod);
        }

        $rutas = [
            [
                'id_ruta' => 1,
                'nombre' => 'Usuarios',
                'href' => 'admin/usuarios',
                'fk_modulo' => 1,
                'icono' => 'UserIcon',
                'listed' => true,
                'estado' => true
            ],
            [
                'id_ruta' => 2,
                'nombre' => 'Fichas',
                'href' => 'admin/fichas',
                'fk_modulo' => 1,
                'icono' => 'TagIcon',
                'listed' => true,
                'estado' => true
            ],
            [
                'id_ruta' => 3,
                'nombre' => 'Areas',
                'href' => 'admin/areas',
                'fk_modulo' => 1,
                'icono' => 'GlobalAmericasIcon',
                'listed' => true,
                'estado' => true
            ],
            [
                'id_ruta' => 4,
                'nombre' => 'Sitios',
                'href' => 'admin/sitios',
                'fk_modulo' => 1,
                'icono' => 'BuildingOfficeIcon',
                'listed' => true,
                'estado' => true
            ],
            [
                'id_ruta' => 6,
                'nombre' => 'Elementos',
                'href' => 'bodega/elementos',
                'fk_modulo' => 2,
                'icono' => 'CubeIcon',
                'listed' => true,
                'estado' => true
            ],
            [
                'id_ruta' => 7,
                'nombre' => 'Movimientos',
                'href' => 'bodega/movimientos',
                'fk_modulo' => 2,
                'icono' => 'ArrowsRightLeftIcon',
                'listed' => true,
                'estado' => true
            ],
            [
                'id_ruta' => 8,
                'nombre' => 'Inventarios',
                'href' => 'bodega/inventario/areas',
                'fk_modulo' => 2,
                'icono' => 'ClipboardDocumentListIcon',
                'listed' => true,
                'estado' => true
            ],
            [
                'id_ruta' => 9,
                'nombre' => 'Reportes',
                'href' => 'reportes',
                'fk_modulo' => 3,
                'listed' => false,
                'estado' => true
            ],
            [
                'id_ruta' => 10,
                'nombre' => 'Roles',
                'href' => 'admin/roles',
                'fk_modulo' => 1,
                'listed' => false,
                'estado' => true
            ],
            [
                'id_ruta' => 11,
                'nombre' => 'Programas formacion',
                'href' => 'admin/programas',
                'fk_modulo' => 1,
                'listed' => false,
                'estado' => true
            ],
            [
                'id_ruta' => 12,
                'nombre' => 'Sedes',
                'href' => 'admin/sedes',
                'fk_modulo' => 1,
                'listed' => false,
                'estado' => true
            ],
            [
                'id_ruta' => 13,
                'nombre' => 'Centros',
                'href' => 'admin/centros',
                'fk_modulo' => 1,
                'listed' => false,
                'estado' => true
            ],
            [
                'id_ruta' => 14,
                'nombre' => 'Municipios',
                'href' => 'admin/municipios',
                'fk_modulo' => 1,
                'listed' => false,
                'estado' => true
            ],
            [
                'id_ruta' => 15,
                'nombre' => 'Tipos Sitios',
                'href' => 'admin/tiposSitio',
                'fk_modulo' => 1,
                'listed' => false,
                'estado' => true
            ],
            [
                'id_ruta' => 16,
                'nombre' => 'Unidades medida',
                'href' => 'bodega/unidades',
                'fk_modulo' => 2,
                'listed' => false,
                'estado' => true
            ],
            [
                'id_ruta' => 17,
                'nombre' => 'Categorias',
                'href' => 'bodega/categorias',
                'fk_modulo' => 2,
                'listed' => false,
                'estado' => true
            ],
            [
                'id_ruta' => 18,
                'nombre' => 'Caracteristicas',
                'href' => 'bodega/caracteristicas',
                'fk_modulo' => 2,
                'listed' => false,
                'estado' => true
            ],
            [
                'id_ruta' => 19,
                'nombre' => 'Tipos movimientos',
                'href' => 'bodega/tipos',
                'fk_modulo' => 2,
                'listed' => false,
                'estado' => true
            ]
        ];

        foreach ($rutas as $ruta) {
            Rutas::create($ruta);
        }

        $permisos = [
            ['id_permiso' => 1, 'permiso' => 'Crear Usuario', 'fk_ruta' => 1],
            ['id_permiso' => 2, 'permiso' => 'Registro Masivo', 'fk_ruta' => 1],
            ['id_permiso' => 3, 'permiso' => 'Listar Usuarios', 'fk_ruta' => 1],
            ['id_permiso' => 4, 'permiso' => 'Actualizar Usuario', 'fk_ruta' => 1],
            ['id_permiso' => 5, 'permiso' => 'Cambiar Estado del Usuario', 'fk_ruta' => 1],

            ['id_permiso' => 6, 'permiso' => 'Crear Ficha', 'fk_ruta' => 2],
            ['id_permiso' => 7, 'permiso' => 'Listar Fichas', 'fk_ruta' => 2],
            ['id_permiso' => 8, 'permiso' => 'Actualizar Ficha', 'fk_ruta' => 2],
            ['id_permiso' => 9, 'permiso' => 'Cambiar Estado de la Ficha', 'fk_ruta' => 2],

            ['id_permiso' => 10, 'permiso' => 'Crear Area', 'fk_ruta' => 3],
            ['id_permiso' => 11, 'permiso' => 'Listar Areas', 'fk_ruta' => 3],
            ['id_permiso' => 12, 'permiso' => 'Actualizar Area', 'fk_ruta' => 3],
            ['id_permiso' => 13, 'permiso' => 'Cambiar Estado del Area', 'fk_ruta' => 3],

            ['id_permiso' => 14, 'permiso' => 'Crear Sitio', 'fk_ruta' => 4],
            ['id_permiso' => 15, 'permiso' => 'Listar Sitios', 'fk_ruta' => 4],
            ['id_permiso' => 16, 'permiso' => 'Actualizar Sitio', 'fk_ruta' => 4],
            ['id_permiso' => 17, 'permiso' => 'Cambiar Estado del Sitio', 'fk_ruta' => 4],

            ['id_permiso' => 18, 'permiso' => 'Crear Elemento', 'fk_ruta' => 6],
            ['id_permiso' => 19, 'permiso' => 'Listar Elemento', 'fk_ruta' => 6],
            ['id_permiso' => 20, 'permiso' => 'Actualizar Elemento', 'fk_ruta' => 6],
            ['id_permiso' => 21, 'permiso' => 'Cambiar estado Elemento', 'fk_ruta' => 6],

            ['id_permiso' => 22, 'permiso' => 'Crear Movimiento', 'fk_ruta' => 7],
            ['id_permiso' => 23, 'permiso' => 'Listar Movimientos', 'fk_ruta' => 7],
            ['id_permiso' => 24, 'permiso' => 'Actualizar Movimiento', 'fk_ruta' => 7],
            ['id_permiso' => 25, 'permiso' => 'Aceptar Movimiento', 'fk_ruta' => 7],
            ['id_permiso' => 26, 'permiso' => 'Cancelar Movimiento', 'fk_ruta' => 7],

            ['id_permiso' => 27, 'permiso' => 'Crear Inventario', 'fk_ruta' => 8],
            ['id_permiso' => 28, 'permiso' => 'Agregar Stock Inventario', 'fk_ruta' => 8],
            ['id_permiso' => 29, 'permiso' => 'Listar Inventario', 'fk_ruta' => 8],
            ['id_permiso' => 30, 'permiso' => 'Actualizar Inventario', 'fk_ruta' => 8],
            ['id_permiso' => 31, 'permiso' => 'Cambiar Estado del Inventario', 'fk_ruta' => 8],

            ['id_permiso' => 32, 'permiso' => 'Ver reportes', 'fk_ruta' => 9],

            ['id_permiso' => 33, 'permiso' => 'Crear Rol', 'fk_ruta' => 10],
            ['id_permiso' => 34, 'permiso' => 'Listar Roles', 'fk_ruta' => 10],
            ['id_permiso' => 35, 'permiso' => 'Actualizar Rol', 'fk_ruta' => 10],
            ['id_permiso' => 36, 'permiso' => 'Cambiar Estado del Rol', 'fk_ruta' => 10],
            ['id_permiso' => 37, 'permiso' => 'Actualizar Permiso', 'fk_ruta' => 10],
            ['id_permiso' => 38, 'permiso' => 'Asignar Permiso', 'fk_ruta' => 10],

            ['id_permiso' => 39, 'permiso' => 'Crear Programa', 'fk_ruta' => 11],
            ['id_permiso' => 40, 'permiso' => 'Listar Programas', 'fk_ruta' => 11],
            ['id_permiso' => 41, 'permiso' => 'Actualizar Programa', 'fk_ruta' => 11],
            ['id_permiso' => 42, 'permiso' => 'Cambiar Estado del Programa', 'fk_ruta' => 11],
            ['id_permiso' => 43, 'permiso' => 'Crear Sedes', 'fk_ruta' => 12],
            ['id_permiso' => 44, 'permiso' => 'Listar Sedes', 'fk_ruta' => 12],
            ['id_permiso' => 45, 'permiso' => 'Actualizar Sedes', 'fk_ruta' => 12],
            ['id_permiso' => 46, 'permiso' => 'Cambiar Estado de la Sede', 'fk_ruta' => 12],

            ['id_permiso' => 47, 'permiso' => 'Crear Centro', 'fk_ruta' => 13],
            ['id_permiso' => 48, 'permiso' => 'Listar Centros', 'fk_ruta' => 13],
            ['id_permiso' => 49, 'permiso' => 'Actualizar Centro', 'fk_ruta' => 13],
            ['id_permiso' => 50, 'permiso' => 'Cambiar Estado del Centro', 'fk_ruta' => 13],

            ['id_permiso' => 51, 'permiso' => 'Crear municipio', 'fk_ruta' => 14],
            ['id_permiso' => 52, 'permiso' => 'Listar municipios', 'fk_ruta' => 14],
            ['id_permiso' => 53, 'permiso' => 'Actualizar municipio', 'fk_ruta' => 14],
            ['id_permiso' => 54, 'permiso' => 'Cambiar Estado del municipio', 'fk_ruta' => 14],

            ['id_permiso' => 55, 'permiso' => 'Crear tipo sitio', 'fk_ruta' => 15],
            ['id_permiso' => 56, 'permiso' => 'Listar tipo de sitios', 'fk_ruta' => 15],
            ['id_permiso' => 57, 'permiso' => 'Actualizar tipo de sitio', 'fk_ruta' => 15],
            ['id_permiso' => 58, 'permiso' => 'Cambiar Estado del tipo de sitio', 'fk_ruta' => 15],

            ['id_permiso' => 59, 'permiso' => 'Crear unidad medida', 'fk_ruta' => 16],
            ['id_permiso' => 60, 'permiso' => 'Listar unidad medida', 'fk_ruta' => 16],
            ['id_permiso' => 61, 'permiso' => 'Actualizar unidad medida', 'fk_ruta' => 16],
            ['id_permiso' => 62, 'permiso' => 'Cambiar Estado de la unidad medida', 'fk_ruta' => 16],

            ['id_permiso' => 63, 'permiso' => 'Crear categoria', 'fk_ruta' => 17],
            ['id_permiso' => 64, 'permiso' => 'Listar categoria', 'fk_ruta' => 17],
            ['id_permiso' => 65, 'permiso' => 'Actualizar categoria', 'fk_ruta' => 17],
            ['id_permiso' => 66, 'permiso' => 'Cambiar Estado de la categoria', 'fk_ruta' => 17],

            ['id_permiso' => 67, 'permiso' => 'Crear caracteristica', 'fk_ruta' => 18],
            ['id_permiso' => 68, 'permiso' => 'Listar caracteristicas', 'fk_ruta' => 18],
            ['id_permiso' => 69, 'permiso' => 'Actualizar caracteristica', 'fk_ruta' => 18],
            ['id_permiso' => 70, 'permiso' => 'Cambiar Estado de la caracteristica', 'fk_ruta' => 18],

            ['id_permiso' => 71, 'permiso' => 'Crear tipo de movimiento', 'fk_ruta' => 19],
            ['id_permiso' => 72, 'permiso' => 'Listar tipos de movimientos', 'fk_ruta' => 19],
            ['id_permiso' => 73, 'permiso' => 'Actualizar tipo de movimiento', 'fk_ruta' => 19],
            ['id_permiso' => 74, 'permiso' => 'Cambiar Estado del tipo de movimiento', 'fk_ruta' => 19],

        ];
        foreach ($permisos as $permiso) {
            Permisos::create($permiso);
        }



        $rolPermisos = [
            ['id_rol_permiso' => 1, 'estado' => true, 'fk_permiso' => 1, 'fk_rol' => 1],
            ['id_rol_permiso' => 2, 'estado' => true, 'fk_permiso' => 2, 'fk_rol' => 1],
            ['id_rol_permiso' => 3, 'estado' => true, 'fk_permiso' => 3, 'fk_rol' => 1],
            ['id_rol_permiso' => 4, 'estado' => true, 'fk_permiso' => 4, 'fk_rol' => 1],
            ['id_rol_permiso' => 5, 'estado' => true, 'fk_permiso' => 5, 'fk_rol' => 1],
            ['id_rol_permiso' => 6, 'estado' => true, 'fk_permiso' => 6, 'fk_rol' => 1],
            ['id_rol_permiso' => 7, 'estado' => true, 'fk_permiso' => 7, 'fk_rol' => 1],
            ['id_rol_permiso' => 8, 'estado' => true, 'fk_permiso' => 8, 'fk_rol' => 1],
            ['id_rol_permiso' => 9, 'estado' => true, 'fk_permiso' => 9, 'fk_rol' => 1],
            ['id_rol_permiso' => 10, 'estado' => true, 'fk_permiso' => 10, 'fk_rol' => 1],
            ['id_rol_permiso' => 11, 'estado' => true, 'fk_permiso' => 11, 'fk_rol' => 1],
            ['id_rol_permiso' => 12, 'estado' => true, 'fk_permiso' => 12, 'fk_rol' => 1],
            ['id_rol_permiso' => 13, 'estado' => true, 'fk_permiso' => 13, 'fk_rol' => 1],
            ['id_rol_permiso' => 14, 'estado' => true, 'fk_permiso' => 14, 'fk_rol' => 1],
            ['id_rol_permiso' => 15, 'estado' => true, 'fk_permiso' => 15, 'fk_rol' => 1],
            ['id_rol_permiso' => 16, 'estado' => true, 'fk_permiso' => 16, 'fk_rol' => 1],
            ['id_rol_permiso' => 17, 'estado' => true, 'fk_permiso' => 17, 'fk_rol' => 1],
            ['id_rol_permiso' => 18, 'estado' => true, 'fk_permiso' => 18, 'fk_rol' => 1],
            ['id_rol_permiso' => 19, 'estado' => true, 'fk_permiso' => 19, 'fk_rol' => 1],
            ['id_rol_permiso' => 20, 'estado' => true, 'fk_permiso' => 20, 'fk_rol' => 1],
            ['id_rol_permiso' => 21, 'estado' => true, 'fk_permiso' => 21, 'fk_rol' => 1],
            ['id_rol_permiso' => 22, 'estado' => true, 'fk_permiso' => 22, 'fk_rol' => 1],
            ['id_rol_permiso' => 23, 'estado' => true, 'fk_permiso' => 23, 'fk_rol' => 1],
            ['id_rol_permiso' => 24, 'estado' => true, 'fk_permiso' => 24, 'fk_rol' => 1],
            ['id_rol_permiso' => 25, 'estado' => true, 'fk_permiso' => 25, 'fk_rol' => 1],
            ['id_rol_permiso' => 26, 'estado' => true, 'fk_permiso' => 26, 'fk_rol' => 1],
            ['id_rol_permiso' => 27, 'estado' => true, 'fk_permiso' => 27, 'fk_rol' => 1],
            ['id_rol_permiso' => 28, 'estado' => true, 'fk_permiso' => 28, 'fk_rol' => 1],
            ['id_rol_permiso' => 29, 'estado' => true, 'fk_permiso' => 29, 'fk_rol' => 1],
            ['id_rol_permiso' => 30, 'estado' => true, 'fk_permiso' => 30, 'fk_rol' => 1],
            ['id_rol_permiso' => 31, 'estado' => true, 'fk_permiso' => 31, 'fk_rol' => 1],
            ['id_rol_permiso' => 32, 'estado' => true, 'fk_permiso' => 32, 'fk_rol' => 1],
            ['id_rol_permiso' => 33, 'estado' => true, 'fk_permiso' => 33, 'fk_rol' => 1],
            ['id_rol_permiso' => 34, 'estado' => true, 'fk_permiso' => 34, 'fk_rol' => 1],
            ['id_rol_permiso' => 35, 'estado' => true, 'fk_permiso' => 35, 'fk_rol' => 1],
            ['id_rol_permiso' => 36, 'estado' => true, 'fk_permiso' => 36, 'fk_rol' => 1],
            ['id_rol_permiso' => 37, 'estado' => true, 'fk_permiso' => 37, 'fk_rol' => 1],
            ['id_rol_permiso' => 38, 'estado' => true, 'fk_permiso' => 38, 'fk_rol' => 1],
            ['id_rol_permiso' => 39, 'estado' => true, 'fk_permiso' => 39, 'fk_rol' => 1],
            ['id_rol_permiso' => 40, 'estado' => true, 'fk_permiso' => 40, 'fk_rol' => 1],
            ['id_rol_permiso' => 41, 'estado' => true, 'fk_permiso' => 41, 'fk_rol' => 1],
            ['id_rol_permiso' => 42, 'estado' => true, 'fk_permiso' => 42, 'fk_rol' => 1],
            ['id_rol_permiso' => 43, 'estado' => true, 'fk_permiso' => 43, 'fk_rol' => 1],
            ['id_rol_permiso' => 44, 'estado' => true, 'fk_permiso' => 44, 'fk_rol' => 1],
            ['id_rol_permiso' => 45, 'estado' => true, 'fk_permiso' => 45, 'fk_rol' => 1],
            ['id_rol_permiso' => 46, 'estado' => true, 'fk_permiso' => 46, 'fk_rol' => 1],
            ['id_rol_permiso' => 47, 'estado' => true, 'fk_permiso' => 47, 'fk_rol' => 1],
            ['id_rol_permiso' => 48, 'estado' => true, 'fk_permiso' => 48, 'fk_rol' => 1],
            ['id_rol_permiso' => 49, 'estado' => true, 'fk_permiso' => 49, 'fk_rol' => 1],
            ['id_rol_permiso' => 50, 'estado' => true, 'fk_permiso' => 50, 'fk_rol' => 1],
            ['id_rol_permiso' => 51, 'estado' => true, 'fk_permiso' => 51, 'fk_rol' => 1],
            ['id_rol_permiso' => 52, 'estado' => true, 'fk_permiso' => 52, 'fk_rol' => 1],
            ['id_rol_permiso' => 53, 'estado' => true, 'fk_permiso' => 53, 'fk_rol' => 1],
            ['id_rol_permiso' => 54, 'estado' => true, 'fk_permiso' => 54, 'fk_rol' => 1],
            ['id_rol_permiso' => 55, 'estado' => true, 'fk_permiso' => 55, 'fk_rol' => 1],
            ['id_rol_permiso' => 56, 'estado' => true, 'fk_permiso' => 56, 'fk_rol' => 1],
            ['id_rol_permiso' => 57, 'estado' => true, 'fk_permiso' => 57, 'fk_rol' => 1],
            ['id_rol_permiso' => 58, 'estado' => true, 'fk_permiso' => 58, 'fk_rol' => 1],
            ['id_rol_permiso' => 59, 'estado' => true, 'fk_permiso' => 59, 'fk_rol' => 1],
            ['id_rol_permiso' => 60, 'estado' => true, 'fk_permiso' => 60, 'fk_rol' => 1],
            ['id_rol_permiso' => 61, 'estado' => true, 'fk_permiso' => 61, 'fk_rol' => 1],
            ['id_rol_permiso' => 62, 'estado' => true, 'fk_permiso' => 62, 'fk_rol' => 1],
            ['id_rol_permiso' => 63, 'estado' => true, 'fk_permiso' => 63, 'fk_rol' => 1],
            ['id_rol_permiso' => 64, 'estado' => true, 'fk_permiso' => 64, 'fk_rol' => 1],
            ['id_rol_permiso' => 65, 'estado' => true, 'fk_permiso' => 65, 'fk_rol' => 1],
            ['id_rol_permiso' => 66, 'estado' => true, 'fk_permiso' => 66, 'fk_rol' => 1],
            ['id_rol_permiso' => 67, 'estado' => true, 'fk_permiso' => 67, 'fk_rol' => 1],
            ['id_rol_permiso' => 68, 'estado' => true, 'fk_permiso' => 68, 'fk_rol' => 1],
            ['id_rol_permiso' => 69, 'estado' => true, 'fk_permiso' => 69, 'fk_rol' => 1],
            ['id_rol_permiso' => 70, 'estado' => true, 'fk_permiso' => 70, 'fk_rol' => 1],
            ['id_rol_permiso' => 71, 'estado' => true, 'fk_permiso' => 71, 'fk_rol' => 1],
            ['id_rol_permiso' => 72, 'estado' => true, 'fk_permiso' => 72, 'fk_rol' => 1],
            ['id_rol_permiso' => 73, 'estado' => true, 'fk_permiso' => 73, 'fk_rol' => 1],
            ['id_rol_permiso' => 74, 'estado' => true, 'fk_permiso' => 74, 'fk_rol' => 1],
        ];

        foreach ($rolPermisos as $rol_permiso) {
            RolPermiso::create($rol_permiso);
        }
    }
}
