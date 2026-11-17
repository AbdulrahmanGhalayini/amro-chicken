<?php

namespace App\Filament\Resources\Offers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OffersTable
{
    public static function configure(Table $table): Table
    {
        return $table
         ->modifyQueryUsing(function ($query) {
                $user = auth()->user();
                
                // If user is business_admin, show only categories related to their business
                if ($user && $user->hasRole('business_admin')) {
                    // Get the business(es) attached to this business_admin
                    $businessIds = $user->businesses()->pluck('business_id')->toArray();
                    $query->whereIn('business_id', $businessIds);
                }
                
                // If super_admin, show all categories (no filter)
                
                return $query;
            })
            ->columns([
                TextColumn::make('business_id')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('image')
                    ->disk('public')
                    ->circular(),
                ToggleColumn::make('active'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}