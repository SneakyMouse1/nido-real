<?php

namespace App\Filament\Agency\Resources\PropertyResource\Pages;

use App\Filament\Agency\Resources\PropertyResource;
use App\Filament\Concerns\HandlesPropertyMedia;
use App\Models\Property;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateProperty extends CreateRecord
{
    use HandlesPropertyMedia;

    protected static string $resource = PropertyResource::class;

    /**
     * Check listings limit before creating a new property.
     */
    protected function beforeCreate(): void
    {
        $agency = Filament::getTenant();

        if (!$agency->hasListingsAvailable()) {
            Notification::make()
                ->title(__('cabinet.limit_reached'))
                ->body(__('cabinet.upgrade_plan_to_add_more'))
                ->warning()
                ->persistent()
                ->send();

            $this->halt();
        }
    }

    /**
     * Auto-assign agency_id and user_id on creation.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['agency_id'] = Filament::getTenant()->id;
        $data['user_id'] = auth()->id();

        return $data;
    }

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
