<?php

namespace App\Policies;

use App\Models\Feature;
use App\Models\User;

class FeaturePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    public function view(User $user, Feature $feature): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    public function update(User $user, Feature $feature): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Feature $feature): bool
    {
        return $user->hasRole('superadmin');
    }
}
