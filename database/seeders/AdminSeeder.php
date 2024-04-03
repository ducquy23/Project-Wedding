<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin::create([
           'name' => 'Admin maneger',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin@123'),
        ]);
    }
}
