<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'agency_manager', 'agent']);
    }

    public function view(User $user, Property $property): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'agency_manager', 'agent']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'agency_manager', 'agent']);
    }

    public function update(User $user, Property $property): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin', 'agency_manager'])) {
            return true;
        }

        return $property->user_id === $user->id;
    }

    public function delete(User $user, Property $property): bool
    {
        if ($user->hasAnyRole(['superadmin', 'agency_manager'])) {
            return true;
        }

        return $property->user_id === $user->id;
    }

    public function restore(User $user, Property $property): bool
    {
        return $user->hasRole('superadmin');
    }

    public function forceDelete(User $user, Property $property): bool
    {
        return $user->hasRole('superadmin');
    }
}
