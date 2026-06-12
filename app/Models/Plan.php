<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Plan extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, HasSlug;

    /**
     * Listings limits by plan slug.
     */
    const LIMITS = [
        'starter'   => 10,
        'pro'       => 50,
        'unlimited' => 999999,
    ];

    protected $fillable = [
        'name',
        'slug',
        'listings_limit',
        'price_eur',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'listings_limit' => 'integer',
            'price_eur'      => 'decimal:2',
            'is_active'      => 'boolean',
            'sort_order'     => 'integer',
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

    public function agencies(): HasMany
    {
        return $this->hasMany(Agency::class);
    }

    // --- Scopes ---

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
