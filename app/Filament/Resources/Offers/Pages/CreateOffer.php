<?php

namespace App\Filament\Resources\Offers\Pages;

use App\Filament\Resources\Offers\OfferResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateOffer extends CreateRecord
{
    protected static string $resource = OfferResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure business_id is set
        if (empty($data['business_id'])) {
            $user = auth()->user();
            if ($user && $user->hasRole('business_admin')) {
                $data['business_id'] = $user->businesses()->pluck('business_id')->first();
            }
        }
        
        return $data;
    }
}
