<?php

namespace App\Filament\Admin\Resources\PropertyResource\Pages;

use App\Filament\Admin\Resources\PropertyResource;
use App\Filament\Concerns\HandlesPropertyMedia;
use App\Models\Property;
use Filament\Resources\Pages\CreateRecord;

class CreateProperty extends CreateRecord
{
    use HandlesPropertyMedia;

    protected static string $resource = PropertyResource::class;

    /**
     * After the property is created, persist floor plans and documents
     * from the Repeater fields into Spatie Media Library collections.
     */
    protected function afterCreate(): void
    {
        /** @var Property $record */
        $record = $this->record;
        $this->saveFloorPlans($record);
        $this->saveDocuments($record);
    }
}
