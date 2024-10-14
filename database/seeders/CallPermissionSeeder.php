<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CallPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::table('menu_group')->truncate();
        DB::table('menu_item')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call([
            PermissionMenuSeeder::class,
            MenuGroupSeeder::class,
            MenuItemSeeder::class,
        ]);
    }
}