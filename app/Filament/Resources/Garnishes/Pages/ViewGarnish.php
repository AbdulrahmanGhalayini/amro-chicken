<?php

namespace App\Filament\Resources\Garnishes\Pages;

use App\Filament\Resources\Garnishes\GarnishResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGarnish extends ViewRecord
{
    protected static string $resource = GarnishResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
