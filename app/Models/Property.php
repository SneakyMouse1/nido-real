<?php

namespace App\Models;

use App\Enums\DealType;
use App\Enums\EnergyCertificate;
use App\Enums\Orientation;
use App\Enums\PropertyStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Property extends \Illuminate\Database\Eloquent\Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    // Fillable properties
    protected $fillable = [
        'user_id',
        'agency_id',
        'property_type_id',
        'title',
        'slug',
        'description',
        'video_url',
        'price',
        'deal_type',
        'price_per_sqm',
        'status',
        'bedrooms',
        'bathrooms',
        'toilets',
        'area_total',
        'area_useful',
        'floor_number',
        'total_floors',
        'year_built',
        'has_garage',
        'has_storage',
        'orientation',
        'energy_certificate',
        'community_fees',
        'ibi_tax',
        'address_line',
        'hide_exact_address',
        'neighborhood',
        'city',
        'province',
        'country',
        'zip_code',
        'latitude',
        'longitude',
        'is_featured',
        'views_count',
        'meta_title',
        'meta_description',
        'property_code',
        'rejection_reason',
    ];

    // Casts for the properties
    protected function casts(): array
    {
        return [
            'deal_type' => DealType::class,
            'status' => PropertyStatus::class,
            'orientation' => Orientation::class,
            'energy_certificate' => EnergyCertificate::class,
            'price' => 'decimal:2',
            'price_per_sqm' => 'decimal:2',
            'community_fees' => 'decimal:2',
            'ibi_tax' => 'decimal:2',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'has_garage' => 'boolean',
            'has_storage' => 'boolean',
            'hide_exact_address' => 'boolean',
            'is_featured' => 'boolean',
            'views_count' => 'integer',
            'bedrooms' => 'integer',
            'bathrooms' => 'integer',
            'toilets' => 'integer',
            'area_total' => 'integer',
            'area_useful' => 'integer',
            'total_floors' => 'integer',
            'year_built' => 'integer',
        ];
    }

    // --- Slug ---

    /**
     * Generate slug in format: {id}-{title-slug}.
     * Called from PropertyObserver::created() when ID is available.
     */
    public function generateSlug(): void
    {
        $this->slug = $this->id.'-'.Str::slug($this->title);
        $this->saveQuietly();
    }

    // --- Boot ---

    protected static function boot(): void
    {
        parent::boot();

        // Auto-calculate price per square meter on saving
        static::saving(function (Property $property) {
            if ($property->price && $property->area_total > 0) {
                $property->price_per_sqm = round($property->price / $property->area_total, 2);
            }
        });

        // Auto-generate property_code after creation (requires ID and optional agency_code)
        static::created(function (Property $property) {
            $property->load('agency');
            self::assignPropertyCode($property);
            $property->saveQuietly();
        });

        // Regenerate property_code when agency_id changes (e.g. Filament Tenancy sets it after creation)
        static::saved(function (Property $property) {
            if ($property->wasChanged('agency_id') && ! $property->wasRecentlyCreated) {
                $property->load('agency');
                self::assignPropertyCode($property);
                $property->saveQuietly();
            }
        });
    }

    /**
     * Build and assign property_code on the given instance.
     * Format: NR-XXXXXX (no agency) or NR-{AGENCY_CODE}-XXXXXX (with agency).
     */
    protected static function assignPropertyCode(Property $property): void
    {
        $padded = str_pad($property->id, 6, '0', STR_PAD_LEFT);
        $agencyCode = $property->agency?->agency_code;

        $property->property_code = $agencyCode
            ? 'NR-'.$agencyCode.'-'.$padded
            : 'NR-'.$padded;
    }

    // --- Spatie Media Library ---

    /**
     * Register media collections for the property.
     * - photos: main property photos (thumb + large conversions)
     * - floor_plans: floor plan images (custom_properties: title_es, title_en)
     * - documents: PDF documents (custom_properties: title, is_public)
     */
    public function registerMediaCollections(): void
    {
        // Main property photographs
        $this->addMediaCollection('photos')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        // Floor plan images (title_es / title_en stored in custom_properties)
        $this->addMediaCollection('floor_plans')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        // PDF documents (is_public stored in custom_properties).
        // Note: browsers (especially on macOS/Safari) may send PDFs as
        // 'application/octet-stream' instead of 'application/pdf'.
        // Filament already validates at the frontend level, so we accept both here.
        $this->addMediaCollection('documents')
            ->useDisk('public')
            ->acceptsMimeTypes(['application/pdf', 'application/octet-stream']);
    }

    /**
     * Register media conversions (thumbnails generated automatically on upload).
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(480)
            ->height(320)
            ->sharpen(5)
            ->nonQueued()
            ->performOnCollections('photos', 'floor_plans');

        $this->addMediaConversion('large')
            ->width(1280)
            ->height(854)
            ->nonQueued()
            ->performOnCollections('photos');
    }

    // --- Relations ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'feature_property');
    }

    // --- Scopes ---

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PropertyStatus::Published->value);
    }

    public function scopeForSale(Builder $query): Builder
    {
        return $query->where('deal_type', DealType::Sale->value);
    }

    public function scopeForRent(Builder $query): Builder
    {
        return $query->where('deal_type', DealType::Rent->value);
    }

    public function scopeForAgency(Builder $query, int $agencyId): Builder
    {
        return $query->where('agency_id', $agencyId);
    }

    public function getEmbedVideoUrlAttribute(): ?string
    {
        $url = $this->video_url;
        if (! $url) {
            return null;
        }

        // YouTube: youtu.be/ID or youtube.com/watch?v=ID
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/))([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1].'?autoplay=1';
        }

        // Vimeo: vimeo.com/ID
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $m)) {
            return 'https://player.vimeo.com/video/'.$m[1].'?autoplay=1';
        }

        return $url;
    }
}
