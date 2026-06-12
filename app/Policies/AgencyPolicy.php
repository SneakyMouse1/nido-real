<?php

namespace App\Policies;

use App\Models\Agency;
use App\Models\User;

class AgencyPolicy
{
    /**
     * Both superadmin and admin can view agencies list.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    public function view(User $user, Agency $agency): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    public function update(User $user, Agency $agency): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    /**
     * Only superadmin can delete agencies.
     */
    public function delete(User $user, Agency $agency): bool
    {
        return $user->hasRole('superadmin');
    }

    public function restore(User $user, Agency $agency): bool
    {
        return $user->hasRole('superadmin');
    }

    public function forceDelete(User $user, Agency $agency): bool
    {
        return $user->hasRole('superadmin');
    }
}
