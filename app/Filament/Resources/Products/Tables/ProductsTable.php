<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();
                
                // If super admin, show all products
                if ($user->hasRole('super_admin')) {
                    return $query;
                }
                
                // If business_admin, show only products from their first business
                $business = $user->businesses()->first();
                if ($business) {
                    return $query->where('business_id', $business->id);
                }
                
                //return $query;
                return $query->orderBy('sort_order', 'asc');
            })
            ->reorderable('sort_order')
            ->reorderRecordsTriggerAction(
                fn($action, $livewire) => $action->button()->label('Reorder')
            )
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('category.name_en')
                    ->sortable()
                     ->getStateUsing(function ($record) {
                        $category = $record->category;
                        if (!$category) {
                            return '-';
                        }
                        
                        if ($category->name_en && $category->name_ar) {
                            return $category->name_en . ' - ' . $category->name_ar;
                        } elseif ($category->name_en) {
                            return $category->name_en;
                        } elseif ($category->name_ar) {
                            return $category->name_ar;
                        }
                        return '-';
                    }),
                ToggleColumn::make('active'),
                ToggleColumn::make('is_new')
                    ->label('Is New'),
                ImageColumn::make('image_1')
                ->disk('public')
                    ->label('Image 1')
                    ->circular()
                    ->getStateUsing(fn ($record) => $record->image_1 
                        ? 'thumbnail/products/' . basename($record->image_1)
                        : ($record->business?->profile_photo ? 'thumbnail/businesses/' . basename($record->business->profile_photo) : null)),

                // ImageColumn::make('image_2')
                //     ->disk('public')
                //     ->label('Image 2')
                //     ->circular()
                //     ->getStateUsing(fn ($record) => $record->image_2 
                //         ? 'products/' . basename($record->image_2)
                //         : null),
                // ImageColumn::make('image_3')
                    // ->disk('public')
                    // ->label('Image 3')
                    // ->circular()
                    // ->getStateUsing(fn ($record) => $record->image_3 
                    //     ? 'products/' . basename($record->image_3)
                    //     : null),
                TextColumn::make('name_en')
                    ->searchable(),
                TextColumn::make('name_ar')
                    ->searchable(),
                TextColumn::make('sale_type')
                    ->label('Sold by')
                    ->badge()
                    ->formatStateUsing(fn ($state, $record) => $state === 'weight'
                        ? 'Kg (' . implode(', ', $record->getWeightChoices()) . ')'
                        : 'Quantity')
                    ->color(fn ($state) => $state === 'weight' ? 'warning' : 'gray'),
                TextColumn::make('price')
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
                        return $business?->currency ?? '';
                    })
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
            ->filters([])
            ->groups([
                Group::make('category_id')
                    ->label('Category')
                    ->getTitleFromRecordUsing(function ($record) {
                        $category = $record->category;
                        if (!$category) return 'Unknown';
                        
                        $businessLanguage = $record->business?->language;
                        
                        if ($businessLanguage === 'en') {
                            return $category->name_en;
                        } elseif ($businessLanguage === 'ar') {
                            return $category->name_ar;
                        }
                        
                        return "{$category->name_en} - {$category->name_ar}";
                    })
                    ->collapsible(),
            ])
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