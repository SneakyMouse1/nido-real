<?php

namespace App\Observers;

use App\Models\Agency;
use Illuminate\Support\Facades\Log;

class AgencyObserver
{
    /**
     * Handle the Agency "updating" event.
     * When plan_id changes, update plan_changed_at timestamp.
     */
    public function updating(Agency $agency): void
    {
        if ($agency->isDirty('plan_id')) {
            $agency->plan_changed_at = now();
            Log::debug("AgencyObserver: Plan changed for agency #{$agency->id} from {$agency->getOriginal('plan_id')} to {$agency->plan_id}");
        }
    }
}
