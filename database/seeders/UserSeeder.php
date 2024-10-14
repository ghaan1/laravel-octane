<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $user = User::find(1);
        $user->assignRole('admin');
        $user = User::find(2);
        $user->assignRole('user');
    }
}
