<?php

namespace App\Models;

use App\Enums\AgencyRole;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'phone',
        'phone_secondary',
        'whatsapp',
        'address',
        'avatar_path',
        'locale',
        'contact_preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'password'            => 'hashed',
            'is_active'           => 'boolean',
            'contact_preferences' => 'array',
        ];
    }

    // --- Filament ---

    /**
     * Determine if the user can access a Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if (!$this->is_active) {
            return false;
        }

        return match ($panel->getId()) {
            'admin'  => $this->hasAnyRole(['superadmin', 'admin']),
            'agency' => $this->hasAnyRole(['agency_manager', 'agent']),
            default  => false,
        };
    }

    // --- Tenancy ---

    /**
     * Get the tenants (agencies) this user belongs to.
     */
    public function getTenants(Panel $panel): Collection
    {
        return $this->agencies;
    }

    /**
     * Determine if the user can access the given tenant (agency).
     */
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->agencies()->where('agencies.id', $tenant->id)->exists();
    }

    // --- Relations ---

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class, 'agency_user')
            ->withPivot('role', 'is_active')
            ->withTimestamps();
    }

    public function managedAgencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class, 'agency_user')
            ->withPivot('role', 'is_active')
            ->withTimestamps()
            ->wherePivot('role', AgencyRole::Manager->value);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_user_favorites')
            ->withPivot('created_at');
    }

    // --- Scopes ---

    public function scopeActive(Builder $query): Builder
    {
        return $query->where($this->getTable() . '.is_active', true);
    }

    /**
     * Get the appropriate dashboard URL for the user based on their roles.
     */
    public function getDashboardUrlAttribute(): string
    {
        if ($this->hasAnyRole(['superadmin', 'admin'])) {
            return url('/secret-admin');
        }

        if ($this->hasAnyRole(['agency_manager', 'agent'])) {
            return url('/cabinet');
        }

        return route('user.profile');
    }
}
