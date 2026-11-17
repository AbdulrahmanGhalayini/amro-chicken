<?php

namespace App\Filament\Resources\Businesses;

use App\Filament\Resources\Businesses\Pages\CreateBusiness;
use App\Filament\Resources\Businesses\Pages\EditBusiness;
use App\Filament\Resources\Businesses\Pages\ListBusinesses;
use App\Filament\Resources\Businesses\Pages\ViewBusiness;
use App\Filament\Resources\Businesses\Schemas\BusinessForm;
use App\Filament\Resources\Businesses\Schemas\BusinessInfolist;
use App\Filament\Resources\Businesses\Tables\BusinessesTable;
use App\Models\Business;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Schema $schema): Schema
    {
        return BusinessForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BusinessInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BusinessesTable::configure($table);
    }

    public static function canCreate(): bool
    {
        // Only super_admin and admin can create businesses
        $user = auth()->user();
        return $user && ($user->hasRole('super_admin') || $user->hasRole('admin'));
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        // Only super_admin can delete businesses
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        // super_admin, admin, and business_admin can edit businesses
        $user = auth()->user();
        return $user && ($user->hasRole('super_admin') || $user->hasRole('admin') || $user->hasRole('business_admin'));
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBusinesses::route('/'),
            'create' => CreateBusiness::route('/create'),
            'view' => ViewBusiness::route('/{record}'),
            'edit' => EditBusiness::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        if (auth()->user()?->hasRole('super_admin')) {
            return static::getModel()::count();
        }
        elseif(auth()->user()?->hasRole('admin')) {
            // For business_admin, show count of users created by them
            return static::getModel()::join('businesses_users', 'businesses.id', '=', 'businesses_users.business_id')
                ->where('businesses_users.created_by', auth()->id())
                ->count();
        }
        else{
            return null;
        }
        
    }
}
