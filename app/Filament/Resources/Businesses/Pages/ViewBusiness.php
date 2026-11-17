<?php

namespace App\Filament\Resources\Businesses\Pages;

use App\Filament\Resources\Businesses\BusinessResource;
use App\Filament\Resources\Businesses\Schemas\BusinessForm;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewBusiness extends ViewRecord
{
    protected static string $resource = BusinessResource::class;

    public function form(Schema $schema): Schema
    {
        $form = BusinessForm::configure($schema);
        
        // Get all components and disable them for read-only viewing
        $components = $form->getComponents();
        foreach ($components as $component) {
            $component->disabled();
        }
        
        return $form;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
