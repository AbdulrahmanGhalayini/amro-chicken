<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Unique;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                MultiSelect::make('roles')
                    ->relationship('roles', 'name')
                    ->options(Role::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->visible(function() {
                        $authUser = Auth::user();
                        return $authUser && $authUser->hasRole('super_admin');
                    })
                    ->label('Roles')
                    ->helperText('Select one or more roles'),
            ]);
    }
}

