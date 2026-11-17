<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class GarnishesRelationManager extends RelationManager
{
    protected static string $relationship = 'garnishes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Garnishes are managed in their own resource
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name_en')
            ->columns([
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
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 0, ',', ',');
                    })
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
                Actions\Action::make('create_garnish')
                    ->label('Create Garnish')
                    ->icon('heroicon-m-plus')
                    ->url(fn () => \App\Filament\Resources\Garnishes\GarnishResource::getUrl('create', ['product_filter' => $this->getOwnerRecord()->id]))
                    ->openUrlInNewTab(false),
            ])
            ->actions([
                Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn ($record) => \App\Filament\Resources\Garnishes\GarnishResource::getUrl('view', ['record' => $record])),
            ])
            ->bulkActions([
                // No bulk actions
            ]);
    }
}
