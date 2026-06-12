<?php

namespace App\Filament\Agency\Resources\PropertyResource\Pages;

use App\Filament\Agency\Resources\PropertyResource;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    public function mount(): void
    {
        parent::mount();

        $agency = Filament::getTenant();

        if (!$agency->hasListingsAvailable()) {
            Notification::make()
                ->title(__('cabinet.limit_reached'))
                ->body(__('cabinet.limit_reached_body'))
                ->warning()
                ->persistent()
                ->actions([
                    \Filament\Actions\Action::make('upgrade')
                        ->label(__('cabinet.upgrade_plan'))
                        ->url(route('billing.plans'))
                        ->button(),
                ])
                ->send();
        }
    }

    protected function getHeaderActions(): array
    {
        $agency = Filament::getTenant();
        $hasLimit = $agency->hasListingsAvailable();

        return [
            CreateAction::make()
                ->label(fn() => __('cabinet.add_property'))
                ->disabled(!$hasLimit)
                ->tooltip(!$hasLimit ? __('cabinet.limit_reached_tooltip') : null),
        ];
    }
}
