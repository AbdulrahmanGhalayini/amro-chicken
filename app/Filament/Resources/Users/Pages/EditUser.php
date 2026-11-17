<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);
        
        $authUser = Auth::user();
        $user = $this->record;
        
        // If not super_admin and record's parent_id doesn't match auth id and not same user, throw 403
        if (!$authUser->hasRole('super_admin') && $user->parent_id !== $authUser->id && $user->id !== $authUser->id) {
            abort(403, 'Unauthorized access');
        }
    }

    protected function beforeSave(): void
    {
        $data = $this->form->getRawState();
        
        // Check for duplicate email (excluding current user)
        $emailExists = \App\Models\User::where('email', $data['email'])
            ->where('id', '!=', $this->record->id)
            ->exists();
        
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
        
        // Validate and filter roles for non-super_admin users
        $roles = $data['roles'] ?? [];
        $authUser = Auth::user();
        
        if ($authUser && $authUser->hasRole('super_admin')) {
            // Super admin can assign any roles
            if (!empty($roles)) {
                // Get the business_admin role ID
                $business_adminRole = \Spatie\Permission\Models\Role::where('name', 'business_admin')->first();
                $business_adminRoleId = $business_adminRole ? $business_adminRole->id : null;
                
                // Filter roles to only include business_admin
                $filteredRoles = [];
                foreach ($roles as $roleId) {
                    if ($roleId == $business_adminRoleId) {
                        $filteredRoles[] = $roleId;
                    }
                }
                
                // If no valid roles, show error
                if (empty($filteredRoles) && !empty($roles)) {
                    Notification::make()
                        ->danger()
                        ->title('Error')
                        ->body('You can only assign the business_admin role.')
                        ->send();
                    $this->halt();
                }
                
                // Update the form data with filtered roles
                $this->form->fill([...$data, 'roles' => $filteredRoles]);
            }
        } else {
            // Non-super_admin users: automatically assign business_admin role
            $business_adminRole = \Spatie\Permission\Models\Role::where('name', 'business_admin')->first();
            if ($business_adminRole) {
                $this->form->fill([...$data, 'roles' => [$business_adminRole->id]]);
            }
        }
    }

    protected function afterSave(): void
    {
        $roles = $this->form->getRawState()['roles'] ?? [];
        if (!empty($roles)) {
            $this->record->roles()->sync($roles);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
