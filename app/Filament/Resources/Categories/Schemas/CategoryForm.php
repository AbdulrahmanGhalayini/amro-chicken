<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Hidden;
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
                // Single store: every record belongs to it.
                Hidden::make('business_id')
                    ->default(fn () => \App\Models\Business::current()?->id)
                    ->required(),
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
