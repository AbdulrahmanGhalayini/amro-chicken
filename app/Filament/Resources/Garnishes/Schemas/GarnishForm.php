<?php

namespace App\Filament\Resources\Garnishes\Schemas;

use Filament\Forms\Components\Hidden;
use App\Models\Business;
use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class GarnishForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Single store: every record belongs to it.
                Hidden::make('business_id')
                    ->default(fn () => \App\Models\Business::current()?->id)
                    ->required(),
                Select::make('product_id')
                    ->required()
                    ->options(function (callable $get) {
                        $business_id = $get('business_id');
                        if (!$business_id) {
                            return [];
                        }
                        return Product::where('business_id', $business_id)
                            ->get()
                            ->mapWithKeys(function ($product) {
                                $label = $product->name_en ?? $product->name_ar ?? 'Unnamed';
                                return [$product->id => (string)$label];
                            })
                            ->toArray();
                    })
                    ->default(function (callable $get) {
                        $productFilter = request()->query('product_filter');
                        if (!$productFilter) {
                            return null;
                        }
                        
                        // Verify the product exists in the business
                        $businessId = $get('business_id');
                        if (!$businessId) {
                            return null;
                        }
                        
                        $productExists = Product::where('business_id', $businessId)
                            ->where('id', $productFilter)
                            ->exists();
                        
                        return $productExists ? $productFilter : null;
                    }),
                TextInput::make('name_en')
                    ->visible(function ($get, $record) {
                        $businessId = $get('business_id') ?? ($record?->business_id);
                        if (!$businessId) {
                            return false;
                        }
                        $business = \App\Models\Business::find($businessId);
                        return $business && in_array($business->language, ['en', 'both']);
                    })
                    ->required(function ($get, $record) {
                        $businessId = $get('business_id') ?? ($record?->business_id);
                        if (!$businessId) {
                            return false;
                        }
                        $business = \App\Models\Business::find($businessId);
                        return $business && in_array($business->language, ['en', 'both']);
                    }),
                TextInput::make('name_ar')
                    ->visible(function ($get, $record) {
                        $businessId = $get('business_id') ?? ($record?->business_id);
                        if (!$businessId) {
                            return false;
                        }
                        $business = \App\Models\Business::find($businessId);
                        return $business && in_array($business->language, ['ar', 'both']);
                    })
                    ->required(function ($get, $record) {
                        $businessId = $get('business_id') ?? ($record?->business_id);
                        if (!$businessId) {
                            return false;
                        }
                        $business = \App\Models\Business::find($businessId);
                        return $business && in_array($business->language, ['ar', 'both']);
                    }),
                
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix(function ($get) {
                        $businessId = $get('business_id');
                        if (!$businessId) {
                            return '';
                        }
                        $business = \App\Models\Business::find($businessId);
                        return $business?->currency ?? '';
                    })
                    ->inputMode('decimal'),
            ]);
    }
}
