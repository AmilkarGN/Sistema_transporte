<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleGerente = Role::firstOrCreate(['name' => 'Gerente']);
        $roleCliente = Role::firstOrCreate(['name' => 'Cliente']);
        $roleConductor = Role::firstOrCreate(['name' => 'Conductor']);

        //Accseso al Dashboard
        Permission::firstOrCreate(['name' => 'ver dashboard'])->syncRoles([$roleAdmin, $roleGerente, $roleCliente, $roleConductor]);

        // Usuarios 
        Permission::firstOrCreate(['name' => 'Ver Boton Usuarios'])->syncRoles([$roleAdmin, $roleGerente]);

        Permission::firstOrCreate(['name' => 'crear usuarios'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminados'])->syncRoles([$roleAdmin]);
        Permission::firstOrCreate(['name' => 'generar reporte'])->syncRoles([$roleAdmin, $roleGerente]);

        Permission::firstOrCreate(['name' => 'ver usuario'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'editar usuario'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminar'])->syncRoles([$roleAdmin, $roleGerente]);


       // Roles y permisos
        Permission::firstOrCreate(['name' => 'Ver Boton Roles'])->syncRoles([$roleAdmin]);

        Permission::firstOrCreate(['name' => 'generar reporte'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'ver detalles combinados'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminados'])->syncRoles([$roleAdmin]);
        Permission::firstOrCreate(['name' => 'crear roles'])->syncRoles([$roleAdmin]);

        Permission::firstOrCreate(['name' => 'editar roles'])->syncRoles([$roleAdmin]);
        Permission::firstOrCreate(['name' => 'eliminar roles'])->syncRoles([$roleAdmin]);
        Permission::firstOrCreate(['name' => 'ver roles'])->syncRoles([$roleAdmin, $roleGerente]);


        // Asignación de permisos a clientes
        Permission::firstOrCreate(['name' => 'Ver Boton Clientes'])->syncRoles([$roleAdmin, $roleGerente]);

        Permission::firstOrCreate(['name' => 'crear clientes'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'reportes clientes'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminados clientes'])->syncRoles([$roleAdmin]);

        Permission::firstOrCreate(['name' => 'ver clientes'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'editar clientes'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminar clientes'])->syncRoles([$roleAdmin, $roleGerente]);


        // Permisos para conductores
        Permission::firstOrCreate(['name' => 'Ver Boton Conductores'])->syncRoles([$roleAdmin, $roleGerente]);

        Permission::firstOrCreate(['name' => 'reportes conductores'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminados conductores'])->syncRoles([$roleAdmin]);
        Permission::firstOrCreate(['name' => 'crear conductores'])->syncRoles([$roleAdmin, $roleGerente]);

        Permission::firstOrCreate(['name' => 'ver conductores'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'editar conductores'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminar conductores'])->syncRoles([$roleAdmin, $roleGerente]);


        // Permisos para vehículos
        Permission::firstOrCreate(['name' => 'Ver Boton Vehiculos'])->syncRoles([$roleAdmin, $roleGerente]);

        Permission::firstOrCreate(['name' => 'crear vehiculos'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'reportes vehiculos'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminados vehiculos'])->syncRoles([$roleAdmin]);

        Permission::firstOrCreate(['name' => 'ver vehiculos'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'editar vehiculos'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminar vehiculos'])->syncRoles([$roleAdmin, $roleGerente]);

        // Permisos para asignación de vehículos
        Permission::firstOrCreate(['name' => 'Ver Boton Asignacion Vehiculos'])->syncRoles([$roleAdmin, $roleConductor, $roleGerente]);

        Permission::firstOrCreate(['name' => 'reportes asignacion vehiculos'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminados asignacion vehiculos'])->syncRoles([$roleAdmin]);
        Permission::firstOrCreate(['name' => 'crear asignacion vehiculos'])->syncRoles([$roleAdmin, $roleGerente]);

        Permission::firstOrCreate(['name' => 'ver asignacion vehiculos'])->syncRoles([$roleAdmin, $roleGerente, $roleConductor]);
        Permission::firstOrCreate(['name' => 'editar asignacion vehiculos'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminar asignacion vehiculos'])->syncRoles([$roleAdmin, $roleGerente]);

        // Permisos para rutas
        Permission::firstOrCreate(['name' => 'Ver Boton Rutas'])->syncRoles([$roleAdmin, $roleGerente]);

        Permission::firstOrCreate(['name' => 'crear rutas'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'reportes rutas'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminados rutas'])->syncRoles([$roleAdmin]);

        Permission::firstOrCreate(['name' => 'ver rutas'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'editar rutas'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminar rutas'])->syncRoles([$roleAdmin, $roleGerente]);

        // Permisos para envíos 
        Permission::firstOrCreate(['name' => 'Ver Boton Envios'])->syncRoles([$roleAdmin, $roleGerente, $roleCliente]);

        Permission::firstOrCreate(['name' => 'crear envios'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'reportes envios'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminados envios'])->syncRoles([$roleAdmin]);

        Permission::firstOrCreate(['name' => 'ver envios'])->syncRoles([$roleAdmin, $roleGerente, $roleCliente]);
        Permission::firstOrCreate(['name' => 'editar envios'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminar envios'])->syncRoles([$roleAdmin, $roleGerente]);

        // Permisos para envíos asignados
        Permission::firstOrCreate(['name' => 'Ver Boton Envios Asignados'])->syncRoles([$roleAdmin, $roleConductor, $roleGerente]);

        Permission::firstOrCreate(['name' => 'crear envios asignados'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'reportes envios asignados'])->syncRoles([$roleAdmin, $roleGerente, $roleConductor]);
        Permission::firstOrCreate(['name' => 'eliminados envios asignados'])->syncRoles([$roleAdmin]);

        Permission::firstOrCreate(['name' => 'ver envios asignados'])->syncRoles([$roleAdmin, $roleGerente, $roleConductor]);
        Permission::firstOrCreate(['name' => 'editar envios asignados'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminar envios asignados'])->syncRoles([$roleAdmin, $roleGerente]);

        // Permisos para peajes
        Permission::firstOrCreate(['name' => 'Ver Boton Peajes'])->syncRoles([$roleAdmin, $roleGerente, $roleConductor]);

        Permission::firstOrCreate(['name' => 'crear peajes'])->syncRoles([$roleAdmin, $roleGerente,$roleConductor]);
        Permission::firstOrCreate(['name' => 'reportes peajes'])->syncRoles([$roleAdmin, $roleGerente, $roleConductor]);
        Permission::firstOrCreate(['name' => 'eliminados peajes'])->syncRoles([$roleAdmin]);
        
        Permission::firstOrCreate(['name' => 'ver peajes'])->syncRoles([$roleAdmin, $roleGerente, $roleConductor]);
        Permission::firstOrCreate(['name' => 'editar peajes'])->syncRoles([$roleAdmin, $roleGerente, $roleConductor]);
        Permission::firstOrCreate(['name' => 'eliminar peajes'])->syncRoles([$roleAdmin, $roleGerente, $roleConductor]);

        // Permisos para viajes
        Permission::firstOrCreate(['name' => 'Ver Boton Viajes'])->syncRoles([$roleAdmin, $roleConductor, $roleGerente, $roleCliente]);

        Permission::firstOrCreate(['name' => 'crear viajes'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'reportes viajes'])->syncRoles([$roleAdmin, $roleGerente, $roleConductor]);
        Permission::firstOrCreate(['name' => 'eliminados viajes'])->syncRoles([$roleAdmin]);

        Permission::firstOrCreate(['name' => 'Asignar ruta'])->syncRoles([$roleAdmin, $roleGerente, $roleConductor]);
        Permission::firstOrCreate(['name' => 'ver viajes'])->syncRoles([$roleAdmin, $roleGerente, $roleConductor, $roleCliente]);
        Permission::firstOrCreate(['name' => 'editar viajes'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminar viajes'])->syncRoles([$roleAdmin, $roleGerente]);

        // Permisos para reservas
        Permission::firstOrCreate(['name' => 'Ver Boton Reservas'])->syncRoles([$roleAdmin, $roleCliente, $roleGerente]);

        Permission::firstOrCreate(['name' => 'reportes reservas'])->syncRoles([$roleAdmin, $roleGerente]);
        Permission::firstOrCreate(['name' => 'eliminados reservas'])->syncRoles([$roleAdmin]);
        Permission::firstOrCreate(['name' => 'crear reservas'])->syncRoles([$roleAdmin, $roleGerente, $roleCliente]);


        Permission::firstOrCreate(['name' => 'ver reservas'])->syncRoles([$roleAdmin, $roleGerente, $roleCliente]);
        Permission::firstOrCreate(['name' => 'editar reservas'])->syncRoles([$roleAdmin, $roleGerente, $roleCliente]);
        Permission::firstOrCreate(['name' => 'eliminar reserva'])->syncRoles([$roleAdmin, $roleGerente]);



        // Calendario Reservas
        Permission::firstOrCreate(['name' => 'Ver Boton Calendario Reservas'])->syncRoles([$roleAdmin, $roleCliente, $roleGerente, $roleConductor]);

        // Otros permisos para reportes, dashboard, etc.




        
    }
}
    