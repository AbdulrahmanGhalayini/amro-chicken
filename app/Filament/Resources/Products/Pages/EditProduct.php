<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);
        $authUser = Auth::user();
        $product = $this->record;
        $businessId = $product->business_id;

        // Super admin can edit all products
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
        // Validate image dependencies
        if (empty($data['image_1'])) {
            $data['image_2'] = null;
            $data['image_3'] = null;
        } elseif (empty($data['image_2'])) {
            $data['image_3'] = null;
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
