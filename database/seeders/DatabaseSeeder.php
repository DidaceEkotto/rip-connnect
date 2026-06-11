<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\AdminSeeder;
use Database\Seeders\ContrySeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\SettingSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RolePermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ContrySeeder::class);
        $this->call(VilleSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
