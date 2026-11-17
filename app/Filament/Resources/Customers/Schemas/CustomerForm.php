<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Customer Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->label('Address')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
