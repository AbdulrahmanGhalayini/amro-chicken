<?php

namespace App\Filament\Resources\Offers;

use App\Filament\Resources\Offers\Pages\CreateOffer;
use App\Filament\Resources\Offers\Pages\EditOffer;
use App\Filament\Resources\Offers\Pages\ListOffers;
use App\Filament\Resources\Offers\Pages\ViewOffer;
use App\Filament\Resources\Offers\Schemas\OfferForm;
use App\Filament\Resources\Offers\Schemas\OfferInfolist;
use App\Filament\Resources\Offers\Tables\OffersTable;
use App\Models\Offer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?int $navigationSort = 7;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    public static function form(Schema $schema): Schema
    {
        return OfferForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OfferInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OffersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOffers::route('/'),
            'create' => CreateOffer::route('/create'),
            'view' => ViewOffer::route('/{record}'),
            'edit' => EditOffer::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        if (auth()->user()?->hasRole('super_admin')) {
            return static::getModel()::count();
        }
        elseif(auth()->user()?->hasRole('business_admin')) {
            // For business_admin, show count of offers created by them
            return static::getModel()::join('businesses_users', 'offers.business_id', '=', 'businesses_users.business_id')
                ->where('businesses_users.user_id', auth()->id())
                ->count();
        }
        else{
            return null;
        }
        
    }
}
