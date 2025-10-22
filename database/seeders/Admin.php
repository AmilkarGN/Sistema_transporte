<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $roleAdmin = Role::firstOrCreate(['name' => 'Administrador']);

    }
}
