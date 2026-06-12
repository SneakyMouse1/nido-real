<?php

namespace App\Filament\Agency\Resources\AgentResource\Pages;

use App\Filament\Agency\Resources\AgentResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateAgent extends CreateRecord
{
    protected static string $resource = AgentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = true;
        $data['locale'] = app()->getLocale();
        return $data;
    }

    protected function afterCreate(): void
    {
        $agency = Filament::getTenant();

        // Attach to agency with agent role
        $this->record->agencies()->attach($agency->id, [
            'role'      => 'agent',
            'is_active' => true,
        ]);

        // Assign role via Spatie
        $this->record->assignRole('agent');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
