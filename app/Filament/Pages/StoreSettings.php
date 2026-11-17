<?php

namespace App\Filament\Pages;

use App\Models\Business;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * The store's own details (name, colours, photos, contacts), edited in one place.
 *
 * @property-read Schema $form
 */
class StoreSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationLabel = 'Store settings';

    protected static ?string $title = 'Store settings';

    protected static ?int $navigationSort = 0;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->store()->attributesToArray());
    }

    protected function store(): Business
    {
        return Business::current() ?? abort(404, 'The store has not been set up yet.');
    }

    public function form(Schema $schema): Schema
    {
        $shows = fn (string $lang) => fn ($get) => in_array($get('language') ?? 'ar', [$lang, 'both']);

        return $schema
            ->model($this->store())
            ->statePath('data')
            ->components([
                Section::make('Store')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name_ar')->label('Name (Arabic)')
                            ->visible($shows('ar'))->required($shows('ar')),
                        TextInput::make('name_en')->label('Name (English)')
                            ->visible($shows('en'))->required($shows('en')),
                        TextInput::make('slogan_ar')->label('Slogan (Arabic)')
                            ->visible($shows('ar')),
                        TextInput::make('slogan_en')->label('Slogan (English)')
                            ->visible($shows('en')),
                        Select::make('language')
                            ->label('Menu language')
                            ->options(['ar' => 'Arabic', 'en' => 'English', 'both' => 'Arabic and English'])
                            ->required()
                            ->live(),
                        ColorPicker::make('theme_color')->label('Theme colour')->required(),
                    ]),
                Section::make('Photos')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('profile_photo')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('businesses')
                            ->maxSize(5120)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])
                            ->helperText('Square image, max 5 MB'),
                        FileUpload::make('cover_photo')
                            ->label('Cover photo')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('businesses')
                            ->maxSize(5120)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['16:9'])
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])
                            ->helperText('Wide image (16:9), max 5 MB'),
                    ]),
                Section::make('Contact')
                    ->columns(2)
                    ->schema([
                        TextInput::make('phone')->tel(),
                        TextInput::make('whatsapp')
                            ->label('WhatsApp number (orders are sent here)')
                            ->helperText('Country code and number, digits only, e.g. 9613123456'),
                        TextInput::make('location_ar')->label('Address (Arabic)')->visible($shows('ar')),
                        TextInput::make('location_en')->label('Address (English)')->visible($shows('en')),
                        TextInput::make('location_url')->label('Google Maps link')->url(),
                        TextInput::make('instagram_url')->label('Instagram link')->url(),
                        TextInput::make('facebook_url')->label('Facebook link')->url(),
                        TextInput::make('tikto_url')->label('TikTok link')->url(),
                    ]),
                Section::make('Prices')
                    ->columns(2)
                    ->schema([
                        Select::make('currency')
                            ->options(['LL' => 'L L', '$' => '$', 'SP' => 'SP'])
                            ->required(),
                        Toggle::make('use_rate')
                            ->label('Also show prices in $')
                            ->live(),
                        TextInput::make('rate')
                            ->label('Exchange rate (1 $ = ? in the store currency)')
                            ->numeric()
                            ->minValue(0)
                            ->visible(fn ($get) => (bool) $get('use_rate')),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')->label('Save')->submit('save')->keyBindings(['mod+s']),
                    ]),
                ]),
        ]);
    }

    public function save(): void
    {
        $store = $this->store();
        $data = $this->form->getState();

        // Removing a photo keeps the current one: the menu always needs a logo and cover.
        foreach (['profile_photo', 'cover_photo'] as $photo) {
            if (blank($data[$photo] ?? null)) {
                unset($data[$photo]);
            }
        }

        $store->update($data);

        Notification::make()->success()->title('Store settings saved')->send();

        $this->form->fill($store->fresh()->attributesToArray());
    }
}
