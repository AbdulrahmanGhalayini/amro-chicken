<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AmroChickenMenuSeeder::class);

        // First admin. Set ADMIN_EMAIL / ADMIN_PASSWORD in .env before seeding.
        $email = env('ADMIN_EMAIL', 'admin@amro-chicken.local');
        $password = env('ADMIN_PASSWORD');
        $admin = User::firstOrCreate(['email' => $email], [
            'name' => 'Amro Chicken Admin',
            'password' => $password ?: ($generated = Str::password(16)),
        ]);

        // The only role in this app; it also attaches the admin to the store.
        $admin->makeStoreAdmin();

        if (isset($generated)) {
            $this->command?->warn("Admin {$email} created with password: {$generated} (change it after first login)");
        }
    }
}
