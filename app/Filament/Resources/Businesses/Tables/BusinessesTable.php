<?php

namespace App\Filament\Resources\Businesses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class BusinessesTable
{
    public static function configure(Table $table): Table
    {
        // dd($table->getQuery());
        return $table
            ->modifyQueryUsing(function ($query) {
                // If user is a business_admin, show only their business
                $user = auth()->user();
                if ($user && $user->hasRole('business_admin')) {
                    $query->whereHas('users', fn ($q) => $q->where('user_id', $user->id));
                    // get the first one 
                    $query->with('users:id,name')->first();
                    return $query;
                }
                elseif ($user && $user->hasRole('admin')) {
                    // If user is admin, show only businesses created by them using the bussises_users table with created_by == auth>-id
                    $query->whereHas('users', fn ($q) => $q->where('created_by', $user->id));
                    
                }
                elseif ($user && $user->hasRole('super_admin')) {
                    // If user is super_admin, show all businesses
                    $query->with('users:id,name');
                    
                }
                $query->with('users:id,name');
                // dd($query->get());
                return $query;
                
            })
            ->columns([
                TextColumn::make('users.name')
                    ->label('Business Admin')
                    ->getStateUsing(fn ($record) => $record->users->first()?->name ?? '-')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('created_by_user_name')
                    ->label('Created By'),
                ImageColumn::make('profile_photo')
                    ->disk('public')
                    ->label('Profile Photo')
                    ->circular()
                    ->getStateUsing(fn ($record) => $record->profile_photo ? 'thumbnail/businesses/' . basename($record->profile_photo) : null),
                TextColumn::make('name')
                    ->getStateUsing(function ($record) {
                        $language = $record->language ?? 'en';
                        return $record->{'name_' . $language} ?? '-';
                    })
                    ->searchable(query: function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name_en', 'like', "%{$search}%")
                        ->orWhere('name_ar', 'like', "%{$search}%");
                    });
                }),
                TextColumn::make('whatsapp')
                    ->badge()
                    ->copyable()
                    ->searchable(),
                IconColumn::make('active')
                    ->boolean(),
                TextColumn::make('language')
                    ->badge(),
                TextColumn::make('currency')
                    ->badge(),
                TextColumn::make('slug')
                    ->badge()
                    ->copyable()
                    ->searchable(),
                ViewColumn::make('qr')
                    ->view('filament.tables.columns.qr-code')
                    ->label('QR Code')
                    ->url(fn ($record) => route('generate-qr', $record->slug))
                    ->openUrlInNewTab(),
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
