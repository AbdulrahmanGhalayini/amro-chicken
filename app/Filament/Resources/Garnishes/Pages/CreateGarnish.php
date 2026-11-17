<?php

namespace App\Filament\Resources\Garnishes\Pages;

use App\Filament\Resources\Garnishes\GarnishResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateGarnish extends CreateRecord
{
    protected static string $resource = GarnishResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure business_id is set - use default if not provided
        if (empty($data['business_id'])) {
            $user = Auth::user();
            $data['business_id'] = $user->businesses()->first()?->id;
        }
        
        return $data;
    }
}
