<?php

namespace App\Filament\Resources\Garnishes;

use App\Filament\Resources\Garnishes\Pages\CreateGarnish;
use App\Filament\Resources\Garnishes\Pages\EditGarnish;
use App\Filament\Resources\Garnishes\Pages\ListGarnishes;
use App\Filament\Resources\Garnishes\Pages\ViewGarnish;
use App\Filament\Resources\Garnishes\Schemas\GarnishForm;
use App\Filament\Resources\Garnishes\Schemas\GarnishInfolist;
use App\Filament\Resources\Garnishes\Tables\GarnishesTable;
use App\Models\Garnish;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GarnishResource extends Resource
{
    protected static ?string $model = Garnish::class;

    protected static ?int $navigationSort = 6;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Schema $schema): Schema
    {
        return GarnishForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GarnishInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GarnishesTable::configure($table);
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        
        // Only super_admin and business_admin users can access
        return $user && ($user->hasRole('super_admin') || $user->hasRole('business_admin'));
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
            'index' => ListGarnishes::route('/'),
            'create' => CreateGarnish::route('/create'),
            'view' => ViewGarnish::route('/{record}'),
            'edit' => EditGarnish::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
    public static function getNavigationBadge(): ?string
    {
        if (auth()->user()?->hasRole('super_admin')) {
            return static::getModel()::count();
        }
        elseif(auth()->user()?->hasRole('business_admin')) {
            // For business_admin, show count of garnishes created by them
            return static::getModel()::join('businesses_users', 'garnishes.business_id', '=', 'businesses_users.business_id')
                ->where('businesses_users.user_id', auth()->id())
                ->count();
        }
        else{
            return null;
        }
        
    }
}
