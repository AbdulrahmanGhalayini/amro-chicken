<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {   
        // dd($schema);
        return $schema
            ->components([
                TextEntry::make('category_id')
                    ->numeric(),
                IconEntry::make('active')
                    ->boolean(),
                IconEntry::make('is_new')
                    ->boolean(),
                ImageEntry::make('image_1')
                    ->label('Image 1')
                    ->disk('public')
                    ->circular(),
                ImageEntry::make('image_2')
                    ->label('Image 2')
                    ->disk('public')
                    ->circular(),
                ImageEntry::make('image_3')
                    ->label('Image 3')
                    ->disk('public')
                    ->circular(),
                TextEntry::make('name_en')
                    ->placeholder('-'),
                TextEntry::make('name_ar')
                    ->placeholder('-'),
                
                TextEntry::make('sale_type')
                    ->label('Sold by')
                    ->badge()
                    ->formatStateUsing(fn ($state, $record) => $state === 'weight'
                        ? 'Kilogram (' . implode(', ', $record->getWeightChoices()) . ' kg)'
                        : 'Quantity'),
                TextEntry::make('price')
                ->formatStateUsing(function ($state) {
                    if ($state === null) return null;

                    // Convert to float in case it's a string
                    $number = (float) $state;

                    // Figure out how many decimal places it currently has
                    $decimals = strlen(substr(strrchr($state, "."), 1));

                    return number_format($number, $decimals, '.', ',');
                })
                    ->suffix(function ($record) {
                        $businessId = $record->business_id;
                        if (!$businessId) {
                            return '';
                        }
                        $business = \App\Models\Business::find($businessId);
                        return ' ' . ($business?->currency ?? '');
                    })
                    ->placeholder('-'),
                TextEntry::make('recipe_en')
                    ->html()
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('recipe_ar')
                    ->html()
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
