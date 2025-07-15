<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class PersonalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('personales')->insert([
            [
                'usuario' => 'santi-admin',
                'nombre' => 'Santiago Altavilla Sforza',
                'password' => '$2y$10$wn1PQstPTZyOmpGhS74ufOY2oN75XfQaLsMZ2ZOIsisoAzdMytt1W',
                'rol' => 'admin',
                'dni' => null,
                'telefono' => null,
                'direccion' => null,
                'correo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}

