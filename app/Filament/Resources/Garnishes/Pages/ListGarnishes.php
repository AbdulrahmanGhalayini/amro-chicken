<?php

namespace App\Filament\Resources\Garnishes\Pages;

use App\Filament\Resources\Garnishes\GarnishResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGarnishes extends ListRecords
{
    protected static string $resource = GarnishResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
