<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('000000'),
                'is_active' => true,
            ]
        );

        // Assigner le rôle et la permission après la création de l'admin
        $admin->assignRole('admin');  // Le rôle admin a le garde 'admin'
        //$admin->givePermissionTo('tous');  // Permission 'tous' pour le garde 'admin'
    }
}
