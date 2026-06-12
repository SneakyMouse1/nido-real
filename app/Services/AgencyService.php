<?php

namespace App\Services;

use App\Models\Agency;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AgencyService
{
    /**
     * Change the agency's plan and update the stored listings_limit snapshot.
     * listings_used is intentionally NOT reset — existing properties keep their slot.
     * If the new limit is lower than listings_used, the agency can't add new listings
     * but existing ones remain visible.
     */
    public function changePlan(Agency $agency, Plan $plan): void
    {
        DB::transaction(function () use ($agency, $plan) {
            $agency->update([
                'plan_id'         => $plan->id,
                'listings_limit'  => $plan->listings_limit,
                'plan_changed_at' => now(),
            ]);

            Log::info("AgencyService: Agency #{$agency->id} ({$agency->name}) plan changed to '{$plan->slug}' (limit: {$plan->listings_limit})");

            Cache::forget("agency_{$agency->id}_dashboard");
        });
    }

    /**
     * Block an agency — hides all its properties from the public frontend
     * via the ActiveAgencyScope global scope.
     */
    public function blockAgency(Agency $agency): void
    {
        $agency->update(['is_active' => false]);
        Log::info("AgencyService: Agency #{$agency->id} ({$agency->name}) has been blocked.");
    }

    /**
     * Unblock a previously blocked agency.
     */
    public function unblockAgency(Agency $agency): void
    {
        $agency->update(['is_active' => true]);
        Log::info("AgencyService: Agency #{$agency->id} ({$agency->name}) has been unblocked.");
    }
}
