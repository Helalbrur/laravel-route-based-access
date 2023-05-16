<?php

namespace Database\Seeders;

use App\Models\MainModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MainModule::factory()->create([
            'main_module' => 'Admin',
            'm_mod_id' => 10,
            'mod_slno' => 21,
            'status' => 1
        ]);
        MainModule::factory()->create([
            'main_module' => 'Lib.',
            'm_mod_id' => 1,
            'mod_slno' => 2,
            'status' => 1
        ]);
    }
}
