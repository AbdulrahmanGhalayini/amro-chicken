<?php

namespace App\Filament\Resources\Garnishes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GarnishInfolist
{
    public static function configure(Schema $schema): Schema
    {   
        return $schema
            ->components([
                TextEntry::make('business_id')
                    ->numeric(),
                TextEntry::make('product_id')
                    ->numeric(),
                TextEntry::make('name_en')
                    ->placeholder('-'),
                TextEntry::make('name_ar')
                    ->placeholder('-'),
                TextEntry::make('price')
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 0, ',', ',');
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
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
