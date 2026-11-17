<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);
        $authUser = Auth::user();
        $category = $this->record;
        $businessId = $category->business_id;

        // Super admin can edit all categories
        if ($authUser->hasRole('super_admin')) {
            return;
        }

        // Business admin: check if user_id in business_user table equals auth id
        if ($authUser->hasRole('admin')) {
            $isAttached = \DB::table('businesses_users')
                ->where('business_id', $businessId)
                ->where('user_id', $authUser->id)
                ->exists();
            if (!$isAttached) {
                abort(403, 'Unauthorized access');
            }
            return;
        }

        // Admin: check if created_by in business_user table equals auth id
        if ($authUser->hasRole('admin')) {
            $isCreatedByAuth = \DB::table('businesses_users')
                ->where('business_id', $businessId)
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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure business_id is set for store admins (cannot change)
        $user = auth()->user();
        if ($user && $user->hasRole('admin')) {
            $data['business_id'] = $this->record->business_id;
        }
        
        return $data;
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
