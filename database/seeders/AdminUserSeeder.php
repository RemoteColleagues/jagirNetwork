<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'fullname' => 'Ritesh Admin',
            'email' => 'admin@gmail.com', // Use your desired admin email
            'contact' => '9869841129',
            'password' => Hash::make('admin123'), // Use a strong password
            'role' => 'admin', // Specify the role as admin
        ]);
    }
}
