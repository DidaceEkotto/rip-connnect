<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $villes = [
            'Yaoundé',
            'Douala',
            'Bamenda',
            'Bafoussam',
            'Garoua',
            'Maroua',
            'Ngaoundéré',
            'Bertoua',
            'Ebolowa',
            'Kribi',
            'Limbé',
            'Buéa',
            'Kumba',
            'Dschang',
            'Foumban',
            'Foumbot',
            'Mbouda',
            'Bafia',
            'Mbalmayo',
            'Sangmélima',
            'Nkongsamba',
            'Edéa',
            'Yabassi',
            'Loum',
            'Manjo',
            'Melong',
            'Tiko',
            'Muyuka',
            'Mamfé',
            'Wum',
            'Kumbo',
            'Nkambe',
            'Batouri',
            'Yokadouma',
            'Abong-Mbang',
            'Belabo',
            'Garoua-Boulaï',
            'Meiganga',
            'Tibati',
            'Tignère',
            'Mokolo',
            'Kaélé',
            'Kousséri',
            'Yagoua',
            'Mora',
            'Guidiguis',
            'Figuil',
            'Pitoa',
            'Guider',
            'Poli',
            'Rey-Bouba',
            'Fundong',
            'Ndop',
            'Bali',
            'Mbengwi',
            'Njinikom',
            'Akonolinga',
            'Obala',
            'Nanga-Eboko',
            'Monatélé',
            'Eseka',
            'Ayos',
            'Lomié',
            'Moloundou',
            'Kette',
            'Dimako',
            'Mbandjock',
            'Nkoteng',
            'Mfou',
            'Soa',
            'Ngoumou',
            'Bokito',
            'Ntui',
            'Yoko',
            'Minta',
            'Messamena',
            'Mintom',
            'Djoum',
            'Ambam',
            'Kye-Ossi',
            'Campo',
            'Lolodorf',
            'Akom II',
            'Kribi II'
        ];

        foreach ($villes as $ville) {

            Ville::create([
                'name'        => $ville,
                'admin_id'    => "1",
                'countrie_id' => "1",
                'slug'        => Str::slug($ville),
                'status'      => "1",
            ]);

        }
    }
}
