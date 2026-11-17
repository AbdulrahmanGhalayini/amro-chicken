<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\Hidden;
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
                // Single store: every record belongs to it.
                Hidden::make('business_id')
                    ->default(fn () => \App\Models\Business::current()?->id)
                    ->required(),
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
