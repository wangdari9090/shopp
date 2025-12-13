<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Admin
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'user_type' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // ✅ Users (3)
        User::firstOrCreate(
            ['email' => 'user1@gmail.com'],
            [
                'name' => 'User One',
                'user_type' => 'user',
                'password' => Hash::make('user123'),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user2@gmail.com'],
            [
                'name' => 'User Two',
                'user_type' => 'user',
                'password' => Hash::make('user123'),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user3@gmail.com'],
            [
                'name' => 'User Three',
                'user_type' => 'user',
                'password' => Hash::make('user123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
