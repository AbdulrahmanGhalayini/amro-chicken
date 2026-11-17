<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->badge()
                    ->copyable(),
                TextColumn::make('parent.name')
                    ->label('Parent')
                    ->sortable(),
                BadgeColumn::make('roles.name')
                    ->label('Roles')
                    ->separator(',')
                    ->badge(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->modifyQueryUsing(function(Builder $query) {
                $authUser = Auth::user();
                
                // If user is super_admin, show all users
                if ($authUser && $authUser->hasRole('super_admin')) {
                    return $query;
                }
                
                // If user is admin, show only users where parent_id equals their id
                if ($authUser && $authUser->hasRole('admin')) {
                    return $query->where('parent_id', $authUser->id);
                }
                
                // For other roles, show only the current user
                return $query->where('id', $authUser->id);
            })

            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
