<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Garnish;
use Illuminate\Auth\Access\HandlesAuthorization;

class GarnishPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Garnish');
    }

    public function view(AuthUser $authUser, Garnish $garnish): bool
    {
        return $authUser->can('View:Garnish');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Garnish');
    }

    public function update(AuthUser $authUser, Garnish $garnish): bool
    {
        return $authUser->can('Update:Garnish');
    }

    public function delete(AuthUser $authUser, Garnish $garnish): bool
    {
        return $authUser->can('Delete:Garnish');
    }

    public function restore(AuthUser $authUser, Garnish $garnish): bool
    {
        return $authUser->can('Restore:Garnish');
    }

    public function forceDelete(AuthUser $authUser, Garnish $garnish): bool
    {
        return $authUser->can('ForceDelete:Garnish');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Garnish');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Garnish');
    }

    public function replicate(AuthUser $authUser, Garnish $garnish): bool
    {
        return $authUser->can('Replicate:Garnish');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Garnish');
    }

}
