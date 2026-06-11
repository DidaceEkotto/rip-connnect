<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
           "user_id" => "1",
           "name_entreprise" => "Rip connect",
           "slug" => "ripconnect",
           "telephone"=> "699329171",
           "telephone_whatsapp" => "699329171",
           "email" => "contact@ripconnect.com",
           "om" => "699329171",
           "localisation"=>"Odza borne 10 en face de la total",
           "ville" => "Yaoundé",
           "statut" => "1",
        ]);
    }
}
