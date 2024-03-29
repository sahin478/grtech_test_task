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
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@grtech.com',
            'password' => Hash::make('password'),
        ]);

        // Create regular user
        User::create([
            'name' => 'User',
            'email' => 'user@grtech.com',
            'password' => Hash::make('password'),
        ]);
    }
}
