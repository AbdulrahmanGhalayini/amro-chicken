<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Columns\ToggleColumn;

use Filament\Tables\Table;

class CategoriesTable
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
                
//                return $query;
return $query->orderBy('sort_order', 'asc');
            })
            ->reorderable('sort_order')
            ->reorderRecordsTriggerAction(
                fn($action, $livewire) => $action->button()->label('Reorder')
            )
            ->columns([
//                TextColumn::make('id')
  //                  ->label('ID')
    //                ->sortable(),
                TextColumn::make('sort_order')
                    ->label('#')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('business_id')
                    ->numeric()
                    ->sortable()
                    ->visible(fn () => auth()->user() && auth()->user()->hasRole('super_admin')),
                ToggleColumn::make('active'),
                ImageColumn::make('image')
                    ->disk('public')
                    ->label('Image')
                    ->circular()
                    ->getStateUsing(fn ($record) => $record->image 
                        ? 'thumbnail/categories/' . basename($record->image)
                        : ($record->business?->profile_photo ? 'thumbnail/businesses/' . basename($record->business->profile_photo) : null)),
                TextColumn::make('name_en')
                    ->searchable(),
                TextColumn::make('name_ar')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ViewColumn::make('editProducts')
                    ->view('filament.resources.categories.tables.columns.edit-products-action')
                    ->label('Edit Products'),
                
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