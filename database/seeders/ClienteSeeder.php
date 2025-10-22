<?php

namespace Database\Seeders;

use App\Models\User; // Importar el modelo User
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // Importar el modelo Role

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurarse de que el rol 'Cliente' existe
        $clienteRole = Role::firstOrCreate(['name' => 'Cliente']);

        // Crear un usuario de ejemplo para el cliente
        // Puedes crear más clientes si lo necesitas
        // User::factory(10)->create()->each(function ($user) use ($clienteRole) {
        //     $user->assignRole($clienteRole);
        // });
    }
}
