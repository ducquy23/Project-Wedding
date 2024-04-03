<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\WebConfig::create([
            'name' => 'Công ty Tinasoft Việt Nam',
            'email' => 'logo',
            'password' => bcrypt('Admin@123'),
        ]);
    }
}
