<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * One store, one role: every user becomes "admin" and the old
     * multi-business roles (super_admin, business_admin, panel_user) are removed.
     */
    public function up(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Role::findOrCreate(User::ADMIN_ROLE, 'web');

        User::query()->each(fn (User $user) => $user->makeStoreAdmin());

        Role::where('name', '!=', User::ADMIN_ROLE)->get()->each->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        // Roles removed here are not recreated.
    }
};
