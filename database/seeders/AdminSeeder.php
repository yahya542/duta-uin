<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'arilianto696@gmail.com'],
            [
                'name' => 'Admin Voting',
                'password' => \Illuminate\Support\Facades\Hash::make('ariliyanto696'),
                'role' => 'admin',
            ]
        );
    }
}
