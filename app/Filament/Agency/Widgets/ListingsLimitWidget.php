<?php

namespace App\Filament\Agency\Widgets;

use App\Enums\PropertyStatus;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class ListingsLimitWidget extends Widget
{
    // Load immediately using cached dashboard data
    protected static bool $isLazy = false;

    // Custom view showing listings usage progress bar
    protected string $view = 'filament.agency.widgets.listings-limit';

    // Display full width on dashboard
    protected int | string | array $columnSpan = 'full';

    public function getData(): array
    {
        $agency = Filament::getTenant();

        // Reuse the same cache key as StatsOverviewWidget
        $data = Cache::remember(
            "agency_{$agency->id}_dashboard",
            now()->addSeconds(30),
            function () use ($agency) {
                return [
                    'published' => $agency->properties()
                        ->where('status', PropertyStatus::Published->value)
                        ->count(),
                    'available' => $agency->getRemainingListings(),
                    'views'     => $agency->properties()->sum('views_count'),
                    'used'      => $agency->listings_used,
                    'limit'     => $agency->plan?->listings_limit ?? 0,
                ];
            }
        );

        $used       = $data['used'];
        $limit      = $data['limit'];
        $percentage = $limit > 0 ? round(($used / $limit) * 100) : 0;

        // Show a persistent warning notification when usage >= 80%
        if ($limit > 0 && $used >= $limit * 0.8 && auth()->user()?->hasRole('agency_manager')) {
            $body = $used >= $limit
                ? __('plans.limit_exceeded_warning')
                : "{$used} / {$limit} " . __('plans.listings_used');

            Notification::make()
                ->title(__('plans.approaching_limit'))
                ->body($body)
                ->warning()
                ->persistent()
                ->send();
        }

        // Color based on usage threshold (also handled in blade, but kept here for fallback)
        $color = 'emerald';
        if ($percentage >= 100) {
            $color = 'red';
        } elseif ($percentage >= 90) {
            $color = 'orange';
        } elseif ($percentage >= 70) {
            $color = 'yellow';
        }

        return [
            'used'        => $used,
            'limit'       => $limit,
            'percentage'  => min($percentage, 100),
            'color'       => $color,
            'isUnlimited' => $limit >= 999999,
        ];
    }
}
