<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            "Cerceuils",
            "Fleures",
            "Véhicules",
            "Marbreries",
        ];

        foreach($categories as $categorie){
            Category::create([
                "admin_id"=> "1",
                "name"=>$categorie,
                "slug"=>Str::slug($categorie),
                "status"=>"1"
            ]);
        }
    }
}
