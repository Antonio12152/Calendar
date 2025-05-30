<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['Anton', 'anton@gmail.com'],
            ['Michael', 'michael@gmail.com'],
            ['Andrew', 'andrew@gmail.com'],
        ];

        foreach ($users as $user) {
            User::create(['name' => $user[0], 'email' => $user[1], 'password' => '12345678']);
        }
    }
}
