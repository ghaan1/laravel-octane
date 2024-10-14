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

        DB::statement('TRUNCATE TABLE permissions CASCADE;');
        DB::statement('TRUNCATE TABLE menu_group CASCADE;');
        DB::statement('TRUNCATE TABLE menu_item CASCADE;');
        $this->call([
            PermissionMenuSeeder::class,
            MenuGroupSeeder::class,
            MenuItemSeeder::class,
        ]);
    }
}
