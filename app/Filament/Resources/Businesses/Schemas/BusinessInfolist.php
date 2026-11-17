<?php

namespace App\Filament\Resources\Businesses\Schemas;

use App\Models\Business;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class BusinessInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                IconEntry::make('active')
                    ->boolean(),
                TextEntry::make('language')
                    ->badge(),
                TextEntry::make('currency')
                    ->badge(),
                TextEntry::make('slug'),
                TextEntry::make('users.name')
                    ->label('Business Admin Name')
                    ->placeholder('-'),
                TextEntry::make('created_by_user')
                    ->label('Created By')
                    ->state(function (Business $record) {
                        $createdById = $record->users()->first()?->pivot->created_by;
                        if ($createdById) {
                            return \App\Models\User::find($createdById)?->name ?? '-';
                        }
                        return '-';
                    })
                    ->placeholder('-'),
                TextEntry::make('slogan'),
                TextEntry::make('theme_color'),
                TextEntry::make('name_en')
                    ->placeholder('-'),
                TextEntry::make('name_ar')
                    ->placeholder('-'),
                ImageEntry::make('profile_photo')
                    ->label('Profile Photo')
                    ->disk('public')
                    ->circular(),
                ImageEntry::make('cover_photo')
                    ->disk('public')
                    ->label('Cover Photo'),
                TextEntry::make('location_en')
                    ->placeholder('-'),
                TextEntry::make('location_ar')
                    ->placeholder('-'),
                TextEntry::make('location_url'),
                TextEntry::make('tikto_url')
                    ->placeholder('-'),
                TextEntry::make('instagram_url')
                    ->placeholder('-'),
                TextEntry::make('facebook_url')
                    ->placeholder('-'),
                TextEntry::make('phone')
                    ->placeholder('-'),
                TextEntry::make('whatsapp')
                    ->placeholder('-'),
                IconEntry::make('use_rate')
                    ->boolean(),
                TextEntry::make('rate')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
