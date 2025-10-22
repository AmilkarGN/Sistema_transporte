<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\ConductorSeeder; // Importar ConductorSeeder
use Database\Seeders\ClienteSeeder; // Importar ClienteSeeder
use Database\Seeders\Admin; // Importar Admin Seeder si es necesario
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create(); // Puedes descomentar si quieres usuarios sin roles específicos

        $this->call(RoleSeeder::class); // Primero crear los roles
        $this->call(ConductorSeeder::class); // Luego crear y asignar conductores
        $this->call(ClienteSeeder::class); // Llama a ClienteSeeder para crear y asignar clientes
        $this->call(Admin::class); // Llama a Admin Seeder para crear y asignar el admin

        // Crear usuario admin si no existe y asignar rol 'Admin'
        

        // Reasignar el rol 'Admin' a usuarios que tengan el rol 'Admin'
        
        // Asignar roles a todos los usuarios según su campo role_id (si existe)
        // (Este bloque ya no es necesario si eliminaste role_id, puedes borrarlo)

        // Crear usuario gerente si no existe y asignar rol 'Gerente'
        
    }
}

