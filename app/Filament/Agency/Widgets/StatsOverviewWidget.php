<?php

namespace App\Filament\Agency\Widgets;

use App\Enums\PropertyStatus;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverviewWidget extends BaseWidget
{
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $agency = Filament::getTenant();

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

        return [
            Stat::make(__('cabinet.published_listings'), $data['published'])
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make(__('cabinet.available_listings'), $data['available'])
                ->icon('heroicon-o-plus-circle')
                ->color($data['available'] > 0 ? 'info' : 'danger'),
            Stat::make(__('cabinet.total_views'), number_format($data['views']))
                ->icon('heroicon-o-eye')
                ->color('warning'),
        ];
    }
}
