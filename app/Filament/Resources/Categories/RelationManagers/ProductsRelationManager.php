<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Products are managed in their own resource
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name_en')
            ->columns([
                Tables\Columns\ImageColumn::make('image_1')
                    ->label('Image')
                    ->disk('public')
                    ->circular()
                    ->state(fn ($record) => $record->image_1 
                        ? $record->image_1 
                        : ($record->business?->profile_photo ?? null)),
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (EN)')
                    ->searchable()
                    ->visible(fn () => auth()->user() && $this->getOwnerRecord()->business?->language !== 'ar'),
                Tables\Columns\TextColumn::make('name_ar')
                    ->label('Name (AR)')
                    ->searchable()
                    ->visible(fn () => auth()->user() && $this->getOwnerRecord()->business?->language !== 'en'),
                Tables\Columns\TextColumn::make('price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('active')
                    ->placeholder('All')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),
            ])
            ->headerActions([
                Actions\Action::make('create_product')
                    ->label('Create Product')
                    ->icon('heroicon-m-plus')
                    ->url(fn () => \App\Filament\Resources\Products\ProductResource::getUrl('create', ['category_filter' => $this->getOwnerRecord()->id]))
                    ->openUrlInNewTab(false),
            ])
            ->actions([
                Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn ($record) => \App\Filament\Resources\Products\ProductResource::getUrl('view', ['record' => $record])),
                Actions\Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-m-pencil')
                    ->url(fn ($record) => \App\Filament\Resources\Products\ProductResource::getUrl('edit', ['record' => $record]))
            ])
            ->bulkActions([
                // No bulk actions
            ]);
    }
}
