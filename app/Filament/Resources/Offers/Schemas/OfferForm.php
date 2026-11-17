<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = auth()->user();

        return $schema
            ->components([
                Select::make('business_id')
                    ->label('Business')
                    ->options(function () use ($user) {
                        $query = \App\Models\Business::query();
                        
                        // If business_admin, show only their business
                        if ($user && $user->hasRole('business_admin')) {
                            $businessIds = $user->businesses()->pluck('business_id')->toArray();
                            $query->whereIn('id', $businessIds);
                        }
                        // Format options as "name_en - name_ar"
                        return $query->get()->mapWithKeys(function ($business) {
                            $label = ($business->name_en ?? '') . ' - ' . ($business->name_ar ?? '');
                            return [$business->id => trim($label, ' - ')];
                        });
                    })
                    ->default(function () use ($user) {
                        // Set default value if user is business_admin
                        if ($user && $user->hasRole('business_admin')) {
                            return $user->businesses()->pluck('business_id')->first();
                        }
                        return null;
                    })
                    ->disabled(function () use ($user) {
                        // Disabled for business_admins
                        return $user && $user->hasRole('business_admin');
                    })
                    ->required()->live(),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('offers') 
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->required(),
                Toggle::make('active')
                    ->default(true),
            ]);
    }
}
