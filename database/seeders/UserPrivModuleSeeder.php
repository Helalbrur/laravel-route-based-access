<?php

namespace Database\Seeders;

use App\Models\UserPrivModule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserPrivModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        UserPrivModule::factory()->create([
            'user_id' => 1,
            'module_id' => 10,
            'valid'=>1
        ]);
        UserPrivModule::factory()->create([
            'user_id' => 1,
            'module_id' => 1,
            'valid'=>1
        ]);
    }
}
