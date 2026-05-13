<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'arilianto696@gmail.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Voting',
                'username' => 'admin_voting',
                'name' => 'Admin Voting',
                'email' => 'arilianto696@gmail.com',
                'whatsapp' => '081234567890',
                'password' => Hash::make('ariliyanto696'),
                'role' => 'admin',
            ]
        );
    }
}
