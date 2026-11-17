<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Business;
use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('business_id')
                    ->required()
                    ->live()
                    ->options(function () {
                        $user = Auth::user();
                        // If super admin, show all businesses
                        if ($user->hasRole('super_admin')) {
                            return Business::get()->mapWithKeys(function ($business) {
                                $label = $business->name_en ?? $business->name_ar ?? 'Unnamed';
                                return [$business->id => (string)$label];
                            })->toArray();
                        }
                        // If business_admin, show only their first business
                        $business = $user->businesses()->first();
                        if (!$business) return [];
                        
                        $label = $business->name_en ?? $business->name_ar ?? 'Unnamed';
                        return [$business->id => (string)$label];
                    })
                    ->default(function () {
                        $user = Auth::user();
                        $businessId = $user->businesses()->first()?->id;
                        return $businessId; // Always return the ID, even if null
                    })
                    ->disabled(function () {
                        $user = Auth::user();
                        // Disabled only if user is not super admin
                        return !$user->hasRole('super_admin');
                    })
                    ->dehydrated(),
                Select::make('category_id')
                    ->required()
                    ->live()
                    ->options(function (callable $get) {
                        $business_id = $get('business_id');
                        if (!$business_id) {return [];}
                        return Category::where('business_id', $business_id)
                            ->get()
                            ->mapWithKeys(function ($category) {
                                $label = $category->name_en ?? $category->name_ar ?? 'Unnamed';
                                return [$category->id => (string)$label];
                            })->toArray();
                    })
                    ->default(function (callable $get) {
                        $categoryFilter = request()->query('category_filter');
                        if (!$categoryFilter) {
                            return null;
                        }
                        
                        // Verify the category exists in the business
                        $businessId = $get('business_id');
                        if (!$businessId) {
                            return null;
                        }
                        
                        $categoryExists = Category::where('business_id', $businessId)
                            ->where('id', $categoryFilter)
                            ->exists();
                        
                        return $categoryExists ? $categoryFilter : null;
                    }),
                
                
                Toggle::make('active')
                    ->required()
                    ->default(true),
                Toggle::make('is_new')
                    ->required(),
                FileUpload::make('image_1')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->imageCropAspectRatio('1:1')
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->live(debounce: 500)
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Clear image_2 and image_3 when image_1 is deleted
                        if (!$state) {
                            $set('image_2', null);
                            $set('image_3', null);
                        }
                    }),
                FileUpload::make('image_2')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->imageCropAspectRatio('1:1')
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->live(debounce: 500)
                    ->hint('Upload Image 1 first')
                    ->hidden(function (callable $get) {
                        return empty($get('image_1'));
                    })
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Clear image_3 when image_2 is deleted
                        if (!$state) {
                            $set('image_3', null);
                        }
                    }),
                FileUpload::make('image_3')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->imageCropAspectRatio('1:1')
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->live(debounce: 500)
                    ->hint('Upload Image 1 and Image 2 first')
                    ->hidden(function (callable $get) {
                        return empty($get('image_2'));
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
                ToggleButtons::make('sale_type')
                    ->label('Sold by')
                    ->options([
                        'unit' => 'Quantity (piece / box)',
                        'weight' => 'Weight (kilogram)',
                    ])
                    ->icons([
                        'unit' => 'heroicon-o-cube',
                        'weight' => 'heroicon-o-scale',
                    ])
                    ->inline()
                    ->default('unit')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        if ($state === 'weight' && empty($get('weight_options'))) {
                            $set('weight_options', array_map('strval', \App\Models\Product::DEFAULT_WEIGHT_OPTIONS));
                        }
                    })
                    ->columnSpanFull(),
                TagsInput::make('weight_options')
                    ->label('Weight choices (kg)')
                    ->helperText('The weights the customer can pick, in kilograms. Example: 0.2, 0.5, 1 (type a number and press Enter).')
                    ->placeholder('e.g. 0.25')
                    ->suggestions(['0.1', '0.2', '0.25', '0.5', '0.75', '1', '1.5', '2'])
                    ->nestedRecursiveRules(['numeric', 'gt:0', 'max:100'])
                    ->default(array_map('strval', \App\Models\Product::DEFAULT_WEIGHT_OPTIONS))
                    ->visible(fn (callable $get) => $get('sale_type') === 'weight')
                    ->required(fn (callable $get) => $get('sale_type') === 'weight')
                    ->dehydrateStateUsing(fn ($state) => collect($state ?? [])
                        ->map(fn ($w) => (float) $w)
                        ->filter(fn ($w) => $w > 0)
                        ->unique()->sort()->values()->all() ?: null)
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->label(fn (callable $get) => $get('sale_type') === 'weight' ? 'Price per 1 kg' : 'Price')
                    ->required()
                    ->rule('numeric')
                    // ->default(0)
                    ->prefix(function ($get) {
                        $businessId = $get('business_id');
                        if (!$businessId) {
                            return '';
                        }
                        $business = \App\Models\Business::find($businessId);
                        return $business?->currency ?? '';
                    }),
                RichEditor::make('recipe_en')
                    ->toolbarButtons([
                    'bold',
                    'bulletList',
                    'italic',
                    'orderedList',
                    'redo',
                    'strike',
                    'underline',
                    'undo',
                ])
                    ->columnSpanFull()
                    ->visible(function () {
                        $user = Auth::user();
                        $business = $user->businesses()->first();
                        return in_array($business?->language, ['en', 'both']);
                    }),
                RichEditor::make('recipe_ar')
                    ->toolbarButtons([
                    'bold',
                    'bulletList',
                    'italic',
                    'orderedList',
                    'redo',
                    'strike',
                    'underline',
                    'undo',
                ])
                    ->columnSpanFull()
                    ->visible(function () {
                        $user = Auth::user();
                        $business = $user->businesses()->first();
                        return in_array($business?->language, ['ar', 'both']);
                    }),
            ]);
    }
}