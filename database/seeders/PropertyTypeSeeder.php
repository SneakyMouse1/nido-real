<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name_es' => 'Apartamento', 'name_en' => 'Apartment',  'icon' => 'heroicon-o-building-office',    'sort_order' => 1],
            ['name_es' => 'Piso',        'name_en' => 'Flat',       'icon' => 'heroicon-o-building-office-2',  'sort_order' => 2],
            ['name_es' => 'Villa',       'name_en' => 'Villa',      'icon' => 'heroicon-o-home-modern',        'sort_order' => 3],
            ['name_es' => 'Casa',        'name_en' => 'House',      'icon' => 'heroicon-o-home',               'sort_order' => 4],
            ['name_es' => 'Adosado',     'name_en' => 'Townhouse',  'icon' => 'heroicon-o-squares-2x2',        'sort_order' => 5],
            ['name_es' => 'Ático',       'name_en' => 'Penthouse',  'icon' => 'heroicon-o-sun',                'sort_order' => 6],
            ['name_es' => 'Estudio',     'name_en' => 'Studio',     'icon' => 'heroicon-o-square-2-stack',     'sort_order' => 7],
            ['name_es' => 'Local',       'name_en' => 'Commercial', 'icon' => 'heroicon-o-building-storefront','sort_order' => 8],
            ['name_es' => 'Garaje',      'name_en' => 'Garage',     'icon' => 'heroicon-o-truck',              'sort_order' => 9],
            ['name_es' => 'Terreno',     'name_en' => 'Land',       'icon' => 'heroicon-o-map',                'sort_order' => 10],
        ];

        foreach ($types as $type) {
            PropertyType::updateOrCreate(
                ['name_es' => $type['name_es']],
                $type
            );
        }
    }
}
