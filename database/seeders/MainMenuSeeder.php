<?php

namespace Database\Seeders;

use App\Models\MainMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MainMenu::factory()->create([
            'm_menu_id' => 5,
            'm_module_id' => 10,
            'menu_name' => 'Menu Management',
            'f_location' => 'tools/create_menu',
            'route_name' => 'create_menu',
            'fabric_nature' => 113,
            'position' => 1,
            'status' => 1,
            'slno' => 5
        ]);

        MainMenu::factory()->create([
            'm_menu_id' => 4,
            'm_module_id' => 10,
            'menu_name' => 'Module Management',
            'f_location' => 'tools/create_main_module',
            'route_name' => 'tools.create_main_module',
            'fabric_nature' => 113,
            'position' => 1,
            'status' => 1,
            'slno' => 4
        ]);

        MainMenu::factory()->create([
            'm_menu_id' => 3,
            'm_module_id' => 10,
            'menu_name' => 'Privilege Management',
            'f_location' => 'tools/user_previledge',
            'route_name' => 'tools.user_previledge',
            'fabric_nature' => 113,
            'position' => 1,
            'status' => 1,
            'slno' => 3
        ]);
    }
}
