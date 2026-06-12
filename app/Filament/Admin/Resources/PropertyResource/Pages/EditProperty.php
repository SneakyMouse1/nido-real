<?php

namespace App\Filament\Admin\Resources\PropertyResource\Pages;

use App\Filament\Admin\Resources\PropertyResource;
use App\Filament\Concerns\HandlesPropertyMedia;
use App\Models\Property;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProperty extends EditRecord
{
    use HandlesPropertyMedia;

    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    /**
     * After saving, persist media then re-fill the form so Repeaters
     * correctly re-initialize their child schemas from fresh DB state.
     *
     * Direct $this->data modification wrote numeric keys into Repeater state
     * while the Repeater had UUID-keyed child schemas for newly added items,
     * causing getChildSchema() to return null → crash in getItemLabel().
     */
    protected function afterSave(): void
    {
        /** @var Property $record */
        $record = $this->record;
        $this->saveFloorPlans($record);
        $this->saveDocuments($record);

        // Reload media relations so mutateFormDataBeforeFill reads fresh Spatie state.
        $record->refresh();
        // Re-initialize the entire form — Repeaters get numeric-keyed items from
        // mutateFormDataBeforeFill and correctly register fresh child schemas.
        $this->fillForm();
    }

    /**
     * Guard against SpatieMediaLibraryFileUpload wiping existing photos.
     *
     * The component uses dehydrated(false), which means photo UUIDs are NOT
     * stored in Livewire's $data between requests. When the form is saved,
     * deleteAbandonedFiles() sees an empty state and deletes ALL photos.
     *
     * Fix: before saveRelationships() runs, restore the UUID array from DB
     * so deleteAbandonedFiles() finds them and leaves them alone.
     */
    protected function beforeSave(): void
    {
        if (empty($this->data['photos'] ?? [])) {
            /** @var Property $record */
            $record = $this->record;
            $existingUuids = $record->getMedia('photos')
                ->mapWithKeys(fn ($media) => [$media->uuid => $media->uuid])
                ->toArray();
            if (! empty($existingUuids)) {
                $this->data['photos'] = $existingUuids;
            }
        }
    }

    /**
     * Pre-populate the documents and floor_plans Repeaters with existing
     * Spatie media so the user can see, edit, delete, or add items when editing.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var Property $record */
        $record = $this->record;

        $data['documents_data'] = $record->getMedia('documents')
            ->map(fn ($media) => [
                'media_uuid'        => $media->uuid,
                'existing_filename' => $media->file_name,
                'title'             => $media->getCustomProperty('title', ''),
                'is_public'         => (bool) $media->getCustomProperty('is_public', false),
                'file'              => null,
            ])
            ->values()
            ->toArray();

        $data['floor_plans_data'] = $record->getMedia('floor_plans')
            ->map(fn ($media) => [
                'media_uuid'        => $media->uuid,
                'existing_filename' => $media->file_name,
                'title_es'          => $media->getCustomProperty('title_es', ''),
                'title_en'          => $media->getCustomProperty('title_en', ''),
                'file'              => null,
            ])
            ->values()
            ->toArray();

        return $data;
    }
}
