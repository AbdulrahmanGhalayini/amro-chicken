<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\EditAction;
// use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class ViewUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);
        
        $authUser = Auth::user();
        $user = $this->record;
        // dd($authUser, $user);
        // If not super_admin and record's parent_id doesn't match auth id and not same user, throw 403
        if (!$authUser->hasRole('super_admin') && $user->parent_id !== $authUser->id ) {
            abort(403, 'Unauthorized access');
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
