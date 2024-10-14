<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuGroup;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class MenuGroupSeeder extends Seeder
{
    public function run()
    {
        // Create permissions for MenuGroups
        $dashboardPermission = Permission::where('name', 'dashboard')->first();
        $settingPermission = Permission::where('name', 'setting')->first();

        MenuGroup::create([
            'nama_menu_group' => 'Dashboard',
            'icon_menu_group' => 'fas fa-tachometer-alt',
            'id_permission_menu_group' => $dashboardPermission->id,
        ]);

        MenuGroup::create([
            'nama_menu_group' => 'Setting',
            'icon_menu_group' => 'fas fa-key',
            'id_permission_menu_group' => $settingPermission->id,
        ]);
    }
}