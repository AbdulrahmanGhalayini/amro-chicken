<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
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
                TextInput::make('name_en')
                    ->visible(function ($get, $record) {
                        $businessId = $get('business_id') ?? ($record?->business_id);
                        if (!$businessId) {
                            return false;
                        }
                        $business = \App\Models\Business::find($businessId);
                        return $business && in_array($business->language, ['en', 'both']);
                    })
                    ->required(function ($get, $record) {
                        $businessId = $get('business_id') ?? ($record?->business_id);
                        if (!$businessId) {
                            return false;
                        }
                        $business = \App\Models\Business::find($businessId);
                        return $business && in_array($business->language, ['en', 'both']);
                    }),
                TextInput::make('name_ar')
                    ->visible(function ($get, $record) {
                        $businessId = $get('business_id') ?? ($record?->business_id);
                        if (!$businessId) {
                            return false;
                        }
                        $business = \App\Models\Business::find($businessId);
                        return $business && in_array($business->language, ['ar', 'both']);
                    })
                    ->required(function ($get, $record) {
                        $businessId = $get('business_id') ?? ($record?->business_id);
                        if (!$businessId) {
                            return false;
                        }
                        $business = \App\Models\Business::find($businessId);
                        return $business && in_array($business->language, ['ar', 'both']);
                    }),
                Toggle::make('active')
                    ->required()
                    ->default(true),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('categories') 
                    ->imageCropAspectRatio('16:9')
                    ->imageEditor()
                    ->imageEditorAspectRatios(['16:9'])
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->helperText('Rectangle image (16:9 aspect ratio) - PNG, JPG, JPEG')
                    ->helperText('If no image is uploaded, the business profile photo will be used.'),
            ]);
    }
}
