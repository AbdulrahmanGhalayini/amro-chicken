<?php

namespace App\Filament\Resources\Garnishes\Pages;

use App\Filament\Resources\Garnishes\GarnishResource;
use Filament\Resources\Pages\EditRecord;

class EditGarnish extends EditRecord
{
    protected static string $resource = GarnishResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }
}
