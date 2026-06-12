<?php

namespace App\Filament\Admin\Resources\FeatureResource\Pages;

use App\Filament\Admin\Resources\FeatureResource;
use Filament\Resources\Pages\ListRecords;

class ListFeatures extends ListRecords
{
    protected static string $resource = FeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
