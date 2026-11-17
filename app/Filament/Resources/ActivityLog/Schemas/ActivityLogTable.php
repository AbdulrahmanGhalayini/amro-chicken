<?php

namespace App\Filament\Resources\ActivityLog\Schemas;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivityLogTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('log_name')
                    ->label('Model')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Action')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'info',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('causer.name')
                    ->label('User')
                    ->sortable()
                    ->searchable()
                    ->placeholder('System'),
                TextColumn::make('subject_type')
                    ->label('Subject Type')
                    ->hidden(),
                TextColumn::make('subject_id')
                    ->label('Subject ID')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Date & Time')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50, 100]);
    }
}
