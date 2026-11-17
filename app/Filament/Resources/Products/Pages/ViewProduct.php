<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);
        $authUser = Auth::user();
        $product = $this->record;
        $businessId = $product->business_id;

        // Super admin can view all products
        if ($authUser->hasRole('super_admin')) {
            return;
        }

        // Business admin: check if user_id in business_user table equals auth id
        if ($authUser->hasRole('business_admin')) {
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

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
