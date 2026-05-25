<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    
    public function run(): void
    {
        User::create([
            'name' => 'Admin Velora',
            'username' => 'admin1',
            'email' => 'admin@velora.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pembeli',
            'username' => 'user1',
            'email' => 'user@velora.com',
            'password' => Hash::make('user1234'),
            'role' => 'buyer',
        ]);
    }
}
