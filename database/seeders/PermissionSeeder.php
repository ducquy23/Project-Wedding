<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
    ];

    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission,'guard_name' => 'admin']);
        }
    }
}
