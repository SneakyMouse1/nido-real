<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if they don't exist
        $roles = ['superadmin', 'admin', 'agency_manager', 'agent', 'owner', 'buyer'];

        foreach ($roles as $role) {
            Role::findOrCreate($role, 'web');
        }

        // Create superadmin user
        $user = User::updateOrCreate(
            ['email' => 'superadmin@nidoreal.com'],
            [
                'name'      => 'Super Admin',
                'password'  => Hash::make(env('SUPERADMIN_PASSWORD', 'secret123')),
                'is_active' => true,
                'locale'    => 'es',
            ]
        );

        // Assign superadmin role
        if (!$user->hasRole('superadmin')) {
            $user->assignRole('superadmin');
        }
    }
}
