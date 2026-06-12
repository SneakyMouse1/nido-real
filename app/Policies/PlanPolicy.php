<?php

namespace App\Policies;

use App\Models\Plan;
use App\Models\User;

class PlanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    public function view(User $user, Plan $plan): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    /**
     * Only superadmin can create/modify plans.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('superadmin');
    }

    public function update(User $user, Plan $plan): bool
    {
        return $user->hasRole('superadmin');
    }

    public function delete(User $user, Plan $plan): bool
    {
        return $user->hasRole('superadmin');
    }
}
