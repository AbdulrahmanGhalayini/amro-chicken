<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Check for duplicate email
        $emailExists = \App\Models\User::where('email', $data['email'])->exists();
        if ($emailExists) {
            Notification::make()
                ->danger()
                ->title('Error')
                ->body('This email is already in use.')
                ->send();
            
            throw ValidationException::withMessages([
                'email' => 'This email is already in use.',
            ]);
        }
        
        // Set parent_id to the currently authenticated user's ID
        $data['parent_id'] = auth()->id();
        
        return $data;
    }

    protected function afterCreate(): void
    {
        $authUser = Auth::user();
        $roles = $this->form->getRawState()['roles'] ?? [];
        $business_adminRole = \Spatie\Permission\Models\Role::where('name', 'business_admin')->first();
        
        if ($authUser && !$authUser->hasRole('super_admin')) {
            // If auth user is not super_admin, always set roles to business_admin
            if ($business_adminRole) {
                $roles = [$business_adminRole->id];
            }
        } else if ($authUser && $authUser->hasRole('super_admin')) {
            // If super_admin, check if there are roles
            if (empty($roles) && $business_adminRole) {
                // If no roles selected, set to business_admin
                $roles = [$business_adminRole->id];
            }
            // If there are roles, they stay as is
        }
        
        if (!empty($roles)) {
            $this->record->roles()->sync($roles);
        }

    }

    protected function getRedirectUrl(): string
    {
        // return $this->getResource()::getUrl('view', ['record' => $this->record]);
        return $this->getResource()::getUrl('index');
    }

    protected function getCreateAnotherRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
}
