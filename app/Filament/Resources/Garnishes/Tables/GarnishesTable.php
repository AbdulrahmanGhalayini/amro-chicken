<?php

namespace App\Filament\Resources\Garnishes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Grouping\Group;
class GarnishesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();
                
                // If super admin, show all garnishes
                if ($user->hasRole('super_admin')) {
                    return $query;
                }
                
                // If business_admin, show only garnishes from their first business
                $business = $user->businesses()->first();
                if ($business) {
                    return $query->where('business_id', $business->id);
                }
                
                return $query;
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
                TextColumn::make('business.name_en')
                    ->label('Business')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        $business = $record->business;
                        if ($business) {
                            if ($business->name_en && $business->name_ar) {
                                return $business->name_en . ' - ' . $business->name_ar;
                            } elseif ($business->name_en) {
                                return $business->name_en;
                            } elseif ($business->name_ar) {
                                return $business->name_ar;
                            }
                        }
                        return '-';
                    }),
                TextColumn::make('product.name_en')
                    ->label('Product')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        $product = $record->product;
                        if ($product) {
                            if ($product->name_en && $product->name_ar) {
                                return $product->name_en . ' - ' . $product->name_ar;
                            } elseif ($product->name_en) {
                                return $product->name_en;
                            } elseif ($product->name_ar) {
                                return $product->name_ar;
                            }
                        }
                        return '-';
                    }),
                TextColumn::make('name_en')
                    ->label('Name')
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        if ($record->name_en && $record->name_ar) {
                            return $record->name_en . ' - ' . $record->name_ar;
                        } elseif ($record->name_en) {
                            return $record->name_en;
                        } elseif ($record->name_ar) {
                            return $record->name_ar;
                        }
                        return '-';
                    }),
                TextColumn::make('name_ar')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('price')
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 0, ',', ',');
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
            ->groups([
                Group::make('product_id')
                    ->label('product')
                    ->getTitleFromRecordUsing(function ($record) {
                        $product = $record->product;
                        if (!$product) return 'Unknown';
                        
                        $businessLanguage = $record->business?->language;
                        
                        if ($businessLanguage === 'en') {
                            return $product->name_en;
                        } elseif ($businessLanguage === 'ar') {
                            return $product->name_ar;
                        }
                        
                        return "{$product->name_en} - {$product->name_ar}";
                    })
                    ->collapsible(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
