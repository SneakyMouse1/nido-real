<?php

namespace App\Observers;

use App\Exceptions\ListingsLimitExceededException;
use App\Models\Property;
use Illuminate\Support\Facades\Log;

class PropertyObserver
{
    /**
     * Handle the Property "creating" event.
     * Enforce listings limit as a backend safeguard (complements the Filament beforeCreate() hook).
     */
    public function creating(Property $property): void
    {
        if (!$property->agency_id) {
            return; // Private seller — separate logic
        }

        $agency = \App\Models\Agency::find($property->agency_id);

        if ($agency && $agency->listings_used >= $agency->listings_limit) {
            throw new ListingsLimitExceededException(__('properties.limit_reached'));
        }
    }

    /**
     * Handle the Property "created" event.
     * Generate slug with ID prefix and increment the agency listings counter.
     */
    public function created(Property $property): void
    {
        // Generate slug now that we have the ID
        $property->generateSlug();
        Log::debug("PropertyObserver: Generated slug '{$property->slug}' for property #{$property->id}");

        // Increment the agency listings counter
        if ($property->agency_id) {
            $property->agency()->increment('listings_used');
            Log::debug("PropertyObserver: Incremented listings_used for agency #{$property->agency_id}");
        }
    }

    /**
     * Handle the Property "deleted" event (soft delete).
     * Do NOT decrement — the listing still occupies a slot until permanently deleted.
     */
    public function deleted(Property $property): void
    {
        // SoftDelete: listings_used is NOT decremented — the slot is still occupied.
    }

    /**
     * Handle the Property "forceDeleted" event.
     * Decrement the agency's listings_used counter.
     * Spatie MediaLibrary automatically cleans up media files.
     */
    public function forceDeleted(Property $property): void
    {
        if ($property->agency_id) {
            $property->agency()->decrement('listings_used');
            Log::debug("PropertyObserver: Decremented listings_used for agency #{$property->agency_id} (force deleted)");
        }
    }

    /**
     * Handle the Property "restored" event (from soft delete).
     * Do NOT increment — the listing was already counted when it was first created.
     */
    public function restored(Property $property): void
    {
        // Restore from soft delete: listings_used is NOT incremented again.
        // It was already counted at creation time.
        if ($property->agency_id) {
            Log::debug("PropertyObserver: Property #{$property->id} restored for agency #{$property->agency_id} — counter unchanged");
        }
    }
}
