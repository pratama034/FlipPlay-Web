<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
                'name' => 'Adit Pratama',
                'email' => 'adit@flipplay.test',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Nadia Putri',
                'email' => 'nadia@flipplay.test',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Rizky Ramadhan',
                'email' => 'rizky@flipplay.test',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(['email' => $userData['email']], $userData);
        }
    }
}
