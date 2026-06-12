<?php

namespace App\Filament\Admin\Resources\PropertyResource\Pages;

use App\Enums\PropertyStatus;
use App\Filament\Admin\Resources\PropertyResource;
use Filament\Actions;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todas')
                ->icon('heroicon-o-squares-2x2'),

            'pending' => Tab::make('Pendiente de revisión')
                ->icon('heroicon-o-clock')
                ->badge(
                    \App\Models\Property::withoutGlobalScope(\App\Models\Scopes\ActiveAgencyScope::class)
                        ->where('status', PropertyStatus::Pending->value)->count()
                )
                ->badgeColor('warning')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->where('status', PropertyStatus::Pending->value)
                ),

            'published' => Tab::make('Publicadas')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->where('status', PropertyStatus::Published->value)
                ),

            'drafts' => Tab::make('Borradores')
                ->icon('heroicon-o-pencil-square')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->where('status', PropertyStatus::Draft->value)
                ),

            'rejected' => Tab::make('Rechazadas')
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->where('status', PropertyStatus::Rejected->value)
                ),
        ];
    }
}
