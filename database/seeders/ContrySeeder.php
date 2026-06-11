<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create([
            "admin_id" => "1",
            "name" => "Cameroun",
            "slug" => "cameroun",
            "indicatif" => "+237",
            "abreviation" => "cm",
            "status" => "1",
        ]);
    }
}
