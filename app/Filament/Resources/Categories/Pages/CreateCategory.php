<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure business_id is set
        if (empty($data['business_id'])) {
            $user = auth()->user();
            if ($user && $user->hasRole('admin')) {
                $data['business_id'] = $user->businesses()->pluck('business_id')->first();
            }
        }
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function getCreateAnotherRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
}
