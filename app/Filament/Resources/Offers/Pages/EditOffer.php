<?php

namespace App\Filament\Resources\Offers\Pages;

use App\Filament\Resources\Offers\OfferResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditOffer extends EditRecord
{
    protected static string $resource = OfferResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);
        $authUser = Auth::user();
        $offer = $this->record;
        $businessId = $offer->business_id;

        // Super admin can edit all offers
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
            DeleteAction::make(),
        ];
    }
}
