<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionMenuSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'dashboard',
            'setting',
            'user.index',
            'user.create',
            'user.edit',
            'user.delete',
            'role.index',
            'role.create',
            'role.edit',
            'role.delete',
            'log.aktivitas.index',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}