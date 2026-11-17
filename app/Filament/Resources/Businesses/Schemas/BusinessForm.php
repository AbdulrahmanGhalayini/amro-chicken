<?php

namespace App\Filament\Resources\Businesses\Schemas;

use App\Policies\BusinessPolicy;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class BusinessForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = auth()->user();

        return $schema
            ->components([
                TextInput::make('slug')
                    ->required()
                    ->disabled(function ($record) use ($user) {
                        if (!auth()->user()?->hasRole('business_admin')) return false;
                        return true;
                    }),
                Select::make('language')
                    ->options(['en' => 'En', 'ar' => 'Ar', 'both' => 'Both'])
                    ->default('en')
                    ->live()
                    ->required()
                    ->disabled(function ($record) use ($user) {
                        if (!auth()->user()?->hasRole('business_admin')) return false;
                        return true;
                    }),
                TextInput::make('name_en')
                    ->visible(fn ($get) => in_array($get('language') ?? 'en', ['en', 'both']))
                    ->required(fn ($get) => in_array($get('language') ?? 'en', ['en', 'both'])),
                TextInput::make('name_ar')
                    ->visible(fn ($get) => in_array($get('language') ?? 'en', ['ar', 'both']))
                    ->required(fn ($get) => in_array($get('language') ?? 'en', ['ar', 'both'])),
                Select::make('currency')
		    ->options(['$' => '$', 'LL' => 'L L', 'SP' => 'SP'])
                    ->required(),
                TextInput::make('slogan_en')
                    ->visible(fn ($get) => in_array($get('language') ?? 'en', ['en', 'both']))
                    ->required(fn ($get) => in_array($get('language') ?? 'en', ['en', 'both'])),
                TextInput::make('slogan_ar')
                    ->visible(fn ($get) => in_array($get('language') ?? 'en', ['ar', 'both']))
                    ->required(fn ($get) => in_array($get('language') ?? 'en', ['ar', 'both'])),
                ColorPicker::make('theme_color')
                    ->required(),
                FileUpload::make('profile_photo')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('businesses')
                    ->maxSize(5120) // 5MB limit
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth(500)
                    ->imageResizeTargetHeight(500)
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->helperText('Square image with white background (PNG, JPG, JPEG) - Max 5MB')
                    ->dehydrated()
                    ->required(),
                FileUpload::make('cover_photo')
                    ->image()
                    ->disk('public')
                    ->maxSize(5120) // 5MB limit
                    ->imageResizeMode('cover')
                    ->visibility('public')
                    ->directory('businesses')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth(1280)
                    ->imageResizeTargetHeight(720)
                    ->imageEditor()
                    ->imageEditorAspectRatios(['16:9'])
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->helperText('Rectangle image (16:9 aspect ratio) - PNG, JPG, JPEG - Max 5MB')
                    ->dehydrated()
                    ->required(),
                TextInput::make('location_en')
                    ->visible(fn ($get) => in_array($get('language') ?? 'en', ['en', 'both']))
                    ->required(fn ($get) => in_array($get('language') ?? 'en', ['en', 'both'])),
                TextInput::make('location_ar')
                    ->visible(fn ($get) => in_array($get('language') ?? 'en', ['ar', 'both']))
                    ->required(fn ($get) => in_array($get('language') ?? 'en', ['ar', 'both'])),
                TextInput::make('location_url')
                    ->url()
                    ->required(),
                TextInput::make('tikto_url')
                    ->url(),
                TextInput::make('instagram_url')
                    ->url(),
                TextInput::make('facebook_url')
                    ->url(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('whatsapp'),
                Toggle::make('active')
                    ->required()
                    ->disabled(function ($record) use ($user) {
                        if (!auth()->user()?->hasRole('business_admin')) return false;
                        return true;
                    }),
                Toggle::make('use_rate')
                    ->required()
                    ->disabled(function ($record) use ($user) {
                        if (!auth()->user()?->hasRole('business_admin')) return false;
                        return true;
                    }),
                TextInput::make('rate')
                    ->numeric(),
                Select::make('user_id')
                    ->label('Select User')
                    ->options(fn ($record) => \App\Models\User::where('parent_id', auth()->id())
                        ->whereHas('roles', fn ($q) => $q->where('name', 'business_admin'))
                        ->where(function ($query) use ($record) {
                            // Show users without businesses OR the currently attached user
                            $query->whereDoesntHave('businesses')
                                ->orWhereHas('businesses', fn ($q) => $q->where('business_id', $record?->id));
                        })
                        ->pluck('name', 'id')
                    )
                    ->getOptionLabelUsing(fn ($value) => \App\Models\User::find($value)?->name)
                    ->searchable()
                    ->preload()
                    ->default(fn ($record) => $record?->users()->first()?->id)
                    ->required()
                    ->disabled(function ($record) use ($user) {
                        if (!auth()->user()?->hasRole('business_admin')) return false;
                        return true;
                    })
                    ->helperText('Select a business admin user to attach to this business'),
            ]);
    }
}