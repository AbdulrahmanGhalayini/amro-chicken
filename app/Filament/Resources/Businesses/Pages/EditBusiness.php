<?php

namespace App\Filament\Resources\Businesses\Pages;

use App\Filament\Resources\Businesses\BusinessResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditBusiness extends EditRecord
{
    protected static string $resource = BusinessResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);
        $authUser = Auth::user();
        $business = $this->record;

        // Super admin can edit all businesses
        if ($authUser->hasRole('super_admin')) {
            return;
        }

        // Business admin: check if user_id in business_user table equals auth id
        if ($authUser->hasRole('business_admin')) {
            $isAttached = $business->users()
                ->where('user_id', $authUser->id)
                ->exists();
            if (!$isAttached) {
                abort(403, 'Unauthorized access');
            }
            return;
        }

        // Admin: check if created_by in business_user table equals auth id
        if ($authUser->hasRole('admin')) {
            $isCreatedByAuth = $business->users()
                ->where('created_by', $authUser->id)
                ->exists();
            if (!$isCreatedByAuth) {
                abort(403, 'Unauthorized access');
            }
            return;
        }

        // All other roles are denied
        abort(403, 'Unauthorized access');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load the currently attached user into the form
        $attachedUser = $this->record->users()->first();
        if ($attachedUser) {
            $data['user_id'] = $attachedUser->id;
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Let all image data pass through (FileUpload will handle paths)
        // The observer will trigger on update and generate thumbnails
        return $data;
    }

    protected function afterSave(): void
    {
        $userId = $this->form->getRawState()['user_id'] ?? null;
        $currentlyAttachedUser = $this->record->users()->first();
        
        if ($userId) {
            // If a different user is selected, detach the old one first
            if ($currentlyAttachedUser && $currentlyAttachedUser->id != $userId) {
                $this->record->users()->detach($currentlyAttachedUser->id);
            }
            
            // Check if this user is already attached to this business
            if (!$this->record->users()->where('user_id', $userId)->exists()) {
                // Add row to businesses_users table
                $this->record->users()->attach($userId, [
                    'created_by' => auth()->id(),
                ]);
            }
        } else if ($currentlyAttachedUser) {
            // If no user is selected but one was previously attached, detach it
            $this->record->users()->detach($currentlyAttachedUser->id);
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
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
