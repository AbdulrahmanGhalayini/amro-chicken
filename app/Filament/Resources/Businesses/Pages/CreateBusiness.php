<?php

namespace App\Filament\Resources\Businesses\Pages;

use App\Filament\Resources\Businesses\BusinessResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBusiness extends CreateRecord
{
    protected static string $resource = BusinessResource::class;

    protected function afterCreate(): void
    {
        $userId = $this->form->getRawState()['user_id'] ?? null;
        
        if ($userId) {
            // Add row to businesses_users table
            $this->record->users()->attach($userId, [
                'created_by' => auth()->id(),
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function getCreateAnotherRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
}



