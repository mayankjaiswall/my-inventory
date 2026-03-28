<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed or update the default admin account in the users table.
     */
    public function run(): void
    {
        $adminName = (string) env('ADMIN_NAME', 'Admin User');
        $adminEmail = (string) env('ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = (string) env('ADMIN_PASSWORD', 'admin12345');

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => $adminName,
                'password' => Hash::make($adminPassword),
                'email_verified_at' => now(),
            ]
        );
    }
}
