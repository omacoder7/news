<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'login' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'login' => 'content_manager',
                'password' => Hash::make('manager123'),
                'role' => 'content_manager',
            ],
            [
                'login' => 'user1',
                'password' => Hash::make('password1'),
                'role' => 'user',
            ],
            [
                'login' => 'user2',
                'password' => Hash::make('password2'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
