<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'master@s.com'],
            [
                'name' => 'MasterO',
                'password' => Hash::make('notabot'),
                'role' => 'master'
            ]
        );

        User::updateOrCreate(
            ['email' => 'mod@s.com'],
            [
                'name' => 'Moderator',
                'password' => Hash::make('notabot'),
                'role' => 'moderator'
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@s.com'],
            [
                'name' => '221110019',
                'password' => Hash::make('notabot'),
                'role' => 'user'
            ]
        );

        User::updateOrCreate(
            ['email' => 'banned@s.com'],
            [
                'name' => 'Pirate',
                'password' => Hash::make('notabot'),
                'role' => 'user',
                'is_banned' => true
            ]
        );

        User::factory()->count(5)->create();
    }
}
