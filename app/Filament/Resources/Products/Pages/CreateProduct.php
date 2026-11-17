<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure business_id is set - use default if not provided
        if (empty($data['business_id'])) {
            $user = Auth::user();
            $data['business_id'] = $user->businesses()->first()?->id;
        }
        
        // Validate image dependencies
        if (empty($data['image_1'])) {
            $data['image_2'] = null;
            $data['image_3'] = null;
        } elseif (empty($data['image_2'])) {
            $data['image_3'] = null;
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
