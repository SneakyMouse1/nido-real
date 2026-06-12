<?php

namespace App\Filament\Agency\Resources\AgentResource\Pages;

use App\Filament\Agency\Resources\AgentResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditAgent extends EditRecord
{
    protected static string $resource = AgentResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        return $data;
    }
}
