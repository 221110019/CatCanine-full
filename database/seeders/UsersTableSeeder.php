<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Database\Factories\UserFactory;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name' => 'MasterO', 'email' => 'master@s.com', 'password' => Hash::make('notabot'), 'role' => 'master']);
        User::create(['name' => 'Moderator', 'email' => 'mod@s.com', 'password' => Hash::make('notabot'), 'role' => 'moderator']);
        User::create(['name' => '221110019', 'email' => 'user@s.com', 'password' => Hash::make('notabot'), 'role' => 'user']);
        User::create(['name' => 'Pirate', 'email' => 'banned@s.com', 'password' => Hash::make('notabot'), 'role' => 'user', 'is_banned' => true]);
        User::factory()->count(5)->create();
    }
}
