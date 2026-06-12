<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            // Interior
            ['name_es' => 'Aire acondicionado',             'name_en' => 'Air Conditioning',        'icon' => 'tabler-smart-home',          'category' => 'interior', 'sort_order' => 1],
            ['name_es' => 'Calefacción central',            'name_en' => 'Central Heating',         'icon' => 'tabler-home-eco',            'category' => 'interior', 'sort_order' => 2],
            ['name_es' => 'Calefacción por suelo radiante', 'name_en' => 'Underfloor Heating',      'icon' => 'tabler-waves-electricity',   'category' => 'interior', 'sort_order' => 3],
            ['name_es' => 'Chimenea',                       'name_en' => 'Fireplace',               'icon' => 'tabler-campfire',            'category' => 'interior', 'sort_order' => 4],
            ['name_es' => 'Cocina equipada',                'name_en' => 'Equipped Kitchen',        'icon' => 'tabler-tools-kitchen-2',     'category' => 'interior', 'sort_order' => 5],
            ['name_es' => 'Cocina americana',               'name_en' => 'Open Kitchen',            'icon' => 'tabler-tools-kitchen-2',     'category' => 'interior', 'sort_order' => 6],
            ['name_es' => 'Armarios empotrados',            'name_en' => 'Built-in Wardrobes',      'icon' => 'tabler-door',               'category' => 'interior', 'sort_order' => 7],
            ['name_es' => 'Vestidor',                       'name_en' => 'Walk-in Closet',          'icon' => 'tabler-door',               'category' => 'interior', 'sort_order' => 8],
            ['name_es' => 'Trastero interior',              'name_en' => 'Interior Storage',        'icon' => 'tabler-lock-square',        'category' => 'interior', 'sort_order' => 9],
            ['name_es' => 'Doble acristalamiento',          'name_en' => 'Double Glazing',          'icon' => 'tabler-window',             'category' => 'interior', 'sort_order' => 10],
            ['name_es' => 'Puerta blindada',                'name_en' => 'Security Door',           'icon' => 'tabler-lock',               'category' => 'interior', 'sort_order' => 11],

            // Exterior
            ['name_es' => 'Terraza',            'name_en' => 'Terrace',          'icon' => 'tabler-home-2',             'category' => 'exterior', 'sort_order' => 1],
            ['name_es' => 'Balcón',             'name_en' => 'Balcony',          'icon' => 'tabler-home-2',             'category' => 'exterior', 'sort_order' => 2],
            ['name_es' => 'Jardín privado',     'name_en' => 'Private Garden',   'icon' => 'tabler-garden-cart',        'category' => 'exterior', 'sort_order' => 3],
            ['name_es' => 'Piscina privada',    'name_en' => 'Private Pool',     'icon' => 'tabler-pool',               'category' => 'exterior', 'sort_order' => 4],
            ['name_es' => 'Barbacoa',           'name_en' => 'Barbecue',         'icon' => 'tabler-campfire',           'category' => 'exterior', 'sort_order' => 5],
            ['name_es' => 'Garaje privado',     'name_en' => 'Private Garage',   'icon' => 'tabler-car-garage',         'category' => 'exterior', 'sort_order' => 6],
            ['name_es' => 'Garaje comunitario', 'name_en' => 'Community Garage', 'icon' => 'tabler-car-garage',         'category' => 'exterior', 'sort_order' => 7],
            ['name_es' => 'Trastero',           'name_en' => 'Storage Room',     'icon' => 'tabler-lock-square',        'category' => 'exterior', 'sort_order' => 8],
            ['name_es' => 'Patio interior',     'name_en' => 'Interior Patio',   'icon' => 'tabler-door-enter',         'category' => 'exterior', 'sort_order' => 9],
            ['name_es' => 'Solarium',           'name_en' => 'Solarium',         'icon' => 'tabler-solar-electricity',  'category' => 'exterior', 'sort_order' => 10],

            // Building
            ['name_es' => 'Piscina comunitaria',        'name_en' => 'Community Pool',       'icon' => 'tabler-pool',               'category' => 'building', 'sort_order' => 1],
            ['name_es' => 'Ascensor',                   'name_en' => 'Elevator',             'icon' => 'tabler-elevator',           'category' => 'building', 'sort_order' => 2],
            ['name_es' => 'Zona verde comunitaria',     'name_en' => 'Community Green Area', 'icon' => 'tabler-garden-cart',        'category' => 'building', 'sort_order' => 3],
            ['name_es' => 'Conserjería',                'name_en' => 'Concierge',            'icon' => 'tabler-home-hand',          'category' => 'building', 'sort_order' => 4],
            ['name_es' => 'Gimnasio',                   'name_en' => 'Gym',                  'icon' => 'tabler-swimming',           'category' => 'building', 'sort_order' => 5],
            ['name_es' => 'Sala de reuniones',          'name_en' => 'Meeting Room',         'icon' => 'tabler-home-star',          'category' => 'building', 'sort_order' => 6],
            ['name_es' => 'Video portero',              'name_en' => 'Video Intercom',       'icon' => 'tabler-camera',             'category' => 'building', 'sort_order' => 7],
            ['name_es' => 'Acceso para discapacitados', 'name_en' => 'Wheelchair Access',    'icon' => 'tabler-wheelchair',         'category' => 'building', 'sort_order' => 8],

            // Security
            ['name_es' => 'Sistema de alarma',    'name_en' => 'Alarm System',     'icon' => 'tabler-alarm-smoke',        'category' => 'security', 'sort_order' => 1],
            ['name_es' => 'Cámaras de seguridad', 'name_en' => 'Security Cameras', 'icon' => 'tabler-camera',             'category' => 'security', 'sort_order' => 2],
            ['name_es' => 'Urbanización cerrada', 'name_en' => 'Gated Community',  'icon' => 'tabler-lock-access',        'category' => 'security', 'sort_order' => 3],
            ['name_es' => 'Vigilancia 24h',       'name_en' => '24h Security',     'icon' => 'tabler-shield-check',       'category' => 'security', 'sort_order' => 4],
            ['name_es' => 'Caja fuerte',          'name_en' => 'Safe',             'icon' => 'tabler-lock-square',        'category' => 'security', 'sort_order' => 5],

            // Technology
            ['name_es' => 'Fibra óptica',                      'name_en' => 'Fiber Optic',         'icon' => 'tabler-wifi',               'category' => 'technology', 'sort_order' => 1],
            ['name_es' => 'Domótica',                          'name_en' => 'Smart Home',          'icon' => 'tabler-smart-home',         'category' => 'technology', 'sort_order' => 2],
            ['name_es' => 'Paneles solares',                   'name_en' => 'Solar Panels',        'icon' => 'tabler-solar-panel',        'category' => 'technology', 'sort_order' => 3],
            ['name_es' => 'Aerotermia',                        'name_en' => 'Aerothermal',         'icon' => 'tabler-wind-electricity',   'category' => 'technology', 'sort_order' => 4],
            ['name_es' => 'Cargador coche eléctrico',          'name_en' => 'EV Charger',          'icon' => 'tabler-charging-pile',      'category' => 'technology', 'sort_order' => 5],
            ['name_es' => 'Preinstalación aire acondicionado', 'name_en' => 'AC Pre-installation', 'icon' => 'tabler-smart-home-off',    'category' => 'technology', 'sort_order' => 6],
        ];

        foreach ($features as $feature) {
            Feature::updateOrCreate(
                ['name_es' => $feature['name_es']],
                $feature
            );
        }
    }
}
