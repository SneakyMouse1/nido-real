<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'agency_manager']);
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'agency_manager']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'agency_manager']);
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'agency_manager']);
    }

    /**
     * Only superadmin can delete users.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasRole('superadmin');
    }

    /**
     * Only superadmin can assign roles.
     */
    public function assignRoles(User $user): bool
    {
        return $user->hasRole('superadmin');
    }

    /**
     * Determine if the authenticated user can toggle is_active on the target user.
     *
     * Rules:
     * - Nobody can deactivate themselves.
     * - Superadmin can deactivate anyone except themselves.
     * - Admin can deactivate users who are NOT admin or superadmin.
     */
    public function toggleActive(User $user, User $model): bool
    {
        // Cannot toggle yourself
        if ($user->id === $model->id) {
            return false;
        }

        // Superadmin can toggle anyone else
        if ($user->hasRole('superadmin')) {
            return true;
        }

        // Admin can toggle only non-admin and non-superadmin users
        if ($user->hasRole('admin')) {
            return !$model->hasAnyRole(['superadmin', 'admin']);
        }

        return false;
    }
}
