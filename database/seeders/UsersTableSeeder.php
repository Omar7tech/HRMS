<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin1234',
            'email' => 'admin@example.com', // You can change this to a valid email address
            'password' => Hash::make('admin1234'),
            'phone_number' => '1234567890', // You can change this to a valid phone number
            'role' => 'admin',
        ]);
    }
}
