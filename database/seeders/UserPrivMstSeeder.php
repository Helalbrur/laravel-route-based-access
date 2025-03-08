<?php

namespace Database\Seeders;

use App\Models\UserPrivMst;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserPrivMstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserPrivMst::factory()->create([
            'user_id'           => 1,
            'main_menu_id'      => 3,
            'show_priv'         => 1,
            'delete_priv'       => 1,
            'save_priv'         => 1,
            'edit_priv'         => 1,
            'approve_priv'      => 1,
            'valid'             => 1
        ]);

        UserPrivMst::factory()->create([
            'user_id'           => 1,
            'main_menu_id'      => 4,
            'show_priv'         => 1,
            'delete_priv'       => 1,
            'save_priv'         => 1,
            'edit_priv'         => 1,
            'approve_priv'      => 1,
            'valid'             => 1
        ]);

        UserPrivMst::factory()->create([
            'user_id'           => 1,
            'main_menu_id'      => 5,
            'show_priv'         => 1,
            'delete_priv'       => 1,
            'save_priv'         => 1,
            'edit_priv'         => 1,
            'approve_priv'      => 1,
            'valid'             => 1
        ]);
    }
}
