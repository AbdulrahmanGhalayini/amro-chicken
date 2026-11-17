<?php

namespace App\Filament\Resources\Businesses\Pages;

use App\Filament\Resources\Businesses\BusinessResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBusinesses extends ListRecords
{
    protected static string $resource = BusinessResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];
        
        $user = auth()->user();
        
        // Only show create button if user is super_admin or admin
        if ($user && ($user->hasRole('super_admin') || $user->hasRole('admin') || $user->hasRole('Super Admin'))) {
            $actions[] = CreateAction::make();
        }
        
        return $actions;
    }
}
