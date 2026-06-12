<?php

namespace App\Models;

use App\Enums\AgencyRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Agency extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, HasSlug, SoftDeletes;

    // Fillable properties
    protected $fillable = [
        'plan_id',
        'name',
        'slug',
        'agency_code',
        'logo_path',
        'phone',
        'email',
        'website',
        'address',
        'city',
        'province',
        'cif',
        'is_active',
        'listings_used',
        'listings_limit',
        'plan_changed_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active'       => 'boolean',
            'listings_used'   => 'integer',
            'listings_limit'  => 'integer',
            'plan_changed_at' => 'datetime',
        ];
    }

    // --- Slug ---

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    // --- Relations ---

    // Plan of the agency
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    // Users of the agency
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'agency_user')
            ->withPivot('role', 'is_active')
            ->withTimestamps();
    }

    // Managers of the agency
    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'agency_user')
            ->withPivot('role', 'is_active')
            ->withTimestamps()
            ->wherePivot('role', AgencyRole::Manager->value);
    }

    // Agents of the agency
    public function agents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'agency_user')
            ->withPivot('role', 'is_active')
            ->withTimestamps()
            ->wherePivot('role', AgencyRole::Agent->value);
    }

    // Properties of the agency
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    // --- Scopes ---

    public function scopeActive(Builder $query): Builder
    {
        return $query->where($this->getTable() . '.is_active', true);
    }

    // --- Helpers ---

    /**
     * Check if the agency has available listings based on the stored limit snapshot.
     */
    public function hasListingsAvailable(): bool
    {
        return $this->listings_used < $this->listings_limit;
    }

    /**
     * Get the number of remaining listings.
     */
    public function getRemainingListings(): int
    {
        return max(0, $this->listings_limit - $this->listings_used);
    }
}
