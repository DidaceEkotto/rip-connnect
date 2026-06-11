<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des rôles
        Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        Role::create(['name' => 'super_review', 'guard_name' => 'admin']);
        Role::create(['name' => 'review', 'guard_name' => 'admin']);
        Role::create(['name' => 'agent_saisie', 'guard_name' => 'admin']);

        // Créer des permissions pour le garde 'admin'
        Permission::create(['name' => 'creation', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edition', 'guard_name' => 'admin']);
        Permission::create(['name' => 'modification', 'guard_name' => 'admin']);
        Permission::create(['name' => 'suppression', 'guard_name' => 'admin']);
        Permission::create(['name' => 'tous', 'guard_name' => 'admin']);
    }
}
