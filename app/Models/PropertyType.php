<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PropertyType extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, HasSlug;

    // Fillable properties
    protected $fillable = [
        'name_es',
        'name_en',
        'slug',
        'icon',
        'is_active',
        'sort_order',
    ];

    // Casts for the properties
    protected function casts(): array
    {
        return [
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // --- Slug ---

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name_es')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    // --- Accessors ---

    /**
     * Get the name based on the current application locale.
     */
    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            return $this->name_en ?? $this->name_es ?? '';
        }

        return $this->name_es ?? $this->name_en ?? '';
    }

    // --- Relations ---

    // Properties of this type
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    // --- Scopes ---

    // Active
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
