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
        \App\Models\Admin::create([
           'username' => 'Admin maneger',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Admin@123'),
        ]);
    }
}
