<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('business_id')
                    ->numeric(),
                IconEntry::make('active')
                    ->boolean(),
                ImageEntry::make('image')
                    ->disk('public')
                    ->label('Image')
                    ->state(fn (Category $record) => $record->image 
                        ? $record->image 
                        : ($record->business?->profile_photo ?? null)),
                TextEntry::make('name_en')
                    ->placeholder('-')
                    ->visible(fn (Category $record): bool => in_array($record->business?->language, ['en', 'both'])),
                TextEntry::make('name_ar')
                    ->placeholder('-')
                    ->visible(fn (Category $record): bool => in_array($record->business?->language, ['ar', 'both'])),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
