<?php

namespace App\Models;

use App\Enums\FeatureCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    // Fillable properties
    protected $fillable = [
        'name_es',
        'name_en',
        'icon',
        'category',
        'is_active',
        'sort_order',
    ];

    // Casts for the properties
    protected function casts(): array
    {
        return [
            'category'   => FeatureCategory::class,
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
        ];
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

    // Properties that have this feature
    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'feature_property');
    }

    // --- Scopes ---

    // Active
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // By category
    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }
}
