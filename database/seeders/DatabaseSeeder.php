<?php

namespace Database\Seeders;

use App\Models\Roles;
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

        User::create([
            'documento' => '1111111111',
            'nombre' => 'admin',
            'apellido' => 'account',
            'estado' => 'true',
            'password' => Hash::make('hola1234'),
            'fk_rol' => '1',
        ]);

        Roles::create([
            'nombre' => 'admin',
            'estado' => 'true',
        ]); 
    }
}
