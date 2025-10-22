<?php

namespace Database\Seeders;

use App\Models\User; // Importar el modelo User
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // Importar el modelo Role (opcional, pero útil para asegurar que el rol existe)

class ConductorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurarse de que el rol 'Conductor' existe
        $conductorRole = Role::firstOrCreate(['name' => 'Conductor']);

        // Crear un usuario de ejemplo para el conductor
        
    }
}
