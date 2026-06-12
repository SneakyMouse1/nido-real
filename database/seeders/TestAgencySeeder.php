<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Plan;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestAgencySeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123');

        // 1. Ensure plans exist
        $proPlan = Plan::where('slug', 'pro')->firstOrFail();
        $starterPlan = Plan::where('slug', 'starter')->firstOrFail();

        $propertyTypes = PropertyType::all();
        if ($propertyTypes->isEmpty()) {
            $this->command->error('No property types found. Please run PropertyTypeSeeder first.');

            return;
        }

        // 2. Setup Agencies
        $agency1 = Agency::firstOrCreate(
            ['email' => 'contact@costablanca.com'],
            [
                'name' => 'Inmobiliaria Costa Blanca',
                'plan_id' => $proPlan->id,
                'phone' => '+34 600 000 000',
                'address' => 'Avenida de la Libertad 1',
                'city' => 'Alicante',
                'province' => 'Alicante',
                'cif' => 'B12345678',
                'is_active' => true,
                'listings_used' => 0,
                'listings_limit' => $proPlan->listings_limit,
                'plan_changed_at' => now(),
            ]
        );

        $agency2 = Agency::firstOrCreate(
            ['email' => 'info@solymar.com'],
            [
                'name' => 'Sol y Mar Propiedades',
                'plan_id' => $starterPlan->id,
                'phone' => '+34 611 111 111',
                'address' => 'Calle Mayor 15',
                'city' => 'Benidorm',
                'province' => 'Alicante',
                'cif' => 'B87654321',
                'is_active' => true,
                'listings_used' => 0,
                'listings_limit' => $starterPlan->listings_limit,
                'plan_changed_at' => now(),
            ]
        );

        $agency3 = Agency::firstOrCreate(
            ['email' => 'contact@mediterraneo.com'],
            [
                'name' => 'Mediterráneo Homes',
                'plan_id' => $starterPlan->id,
                'phone' => '+34 622 222 222',
                'address' => 'Plaza de la Constitución 5',
                'city' => 'Torrevieja',
                'province' => 'Alicante',
                'cif' => 'B55555555',
                'is_active' => true,
                'listings_used' => 0,
                'listings_limit' => $starterPlan->listings_limit,
                'plan_changed_at' => now(),
            ]
        );

        // 3. Users per agency
        // Props count removed - properties are created by PropertySeeder
        $usersData = [
            [
                'agency' => $agency1,
                'users' => [
                    ['email' => 'manager@nidoreal.com',  'name' => 'Carlos García',   'role' => 'agency_manager'],
                    ['email' => 'agent@nidoreal.com',    'name' => 'María López',      'role' => 'agent'],
                    ['email' => 'agent2@nidoreal.com',   'name' => 'Pedro Martínez',   'role' => 'agent'],
                ],
            ],
            [
                'agency' => $agency2,
                'users' => [
                    ['email' => 'manager2@nidoreal.com', 'name' => 'Ana Rodríguez',   'role' => 'agency_manager'],
                    ['email' => 'agent3@nidoreal.com',   'name' => 'Luis Fernández',   'role' => 'agent'],
                    ['email' => 'agent4@nidoreal.com',   'name' => 'Sofia Gómez',      'role' => 'agent'],
                ],
            ],
            [
                'agency' => $agency3,
                'users' => [
                    ['email' => 'manager3@nidoreal.com', 'name' => 'Roberto Sánchez', 'role' => 'agency_manager'],
                    ['email' => 'agent5@nidoreal.com',   'name' => 'Elena Torres',    'role' => 'agent'],
                ],
            ],
        ];

        // 3. Create logos
        $agenciesToSeed = [
            ['model' => $agency1, 'url' => 'https://picsum.photos/seed/agency-costablanca/200/200'],
            ['model' => $agency2, 'url' => 'https://picsum.photos/seed/agency-solymar/200/200'],
            ['model' => $agency3, 'url' => 'https://picsum.photos/seed/agency-mediterraneo/200/200'],
        ];

        foreach ($agenciesToSeed as $data) {
            $agency = $data['model'];
            $url = $data['url'];

            try {
                $contents = file_get_contents($url);
                $filename = 'logo-'.$agency->id.'.jpg';
                $path = 'agencies/logos/'.$filename;

                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $contents);

                $agency->update(['logo_path' => $path]);
            } catch (\Throwable $e) {
                $this->command->warn("Logo no accesible para {$agency->name}: ".$e->getMessage());
            }
        }

        $totalUsers = 0;

        foreach ($usersData as $agencyData) {
            $agency = $agencyData['agency'];
            $syncData = [];

            foreach ($agencyData['users'] as $uData) {
                $pivotRole = $uData['role'] === 'agency_manager' ? 'manager' : 'agent';

                $user = User::firstOrCreate(
                    ['email' => $uData['email']],
                    [
                        'name' => $uData['name'],
                        'password' => $password,
                        'is_active' => true,
                        'email_verified_at' => now(),
                    ]
                );

                if (! $user->hasRole($uData['role'])) {
                    $user->assignRole($uData['role']);
                }

                $syncData[$user->id] = ['role' => $pivotRole, 'is_active' => true];
                $totalUsers++;
            }

            // Attach users to agency
            $agency->users()->syncWithoutDetaching($syncData);
        }

        $this->command->info('--- TestAgencySeeder COMPLETE ---');
        $this->command->info("Agencies: 3 | Users: {$totalUsers}");
        $this->command->info('Properties will be created by PropertySeeder.');
    }
}
