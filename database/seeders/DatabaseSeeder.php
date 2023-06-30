<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Exception;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\MainMenuSeeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\MainModuleSeeder;
use Database\Seeders\UserPrivMstSeeder;
use Database\Seeders\UserPrivModuleSeeder;
use Database\Seeders\LibCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::beginTransaction();
        try
        {
            $filePath = database_path('seeders/backup.sql');

            if (file_exists($filePath)) {
                $sql = file_get_contents($filePath);
                DB::unprepared($sql);
            }
            else
            {
                User::factory()->create([
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'password'=>Hash::make('12345678')
                ]);
                $this->call(LibCategorySeeder::class);
                $this->call(MainModuleSeeder::class);
                $this->call(MainMenuSeeder::class);
                $this->call(UserPrivModuleSeeder::class);
                $this->call(UserPrivMstSeeder::class);
                DB::commit();
            }

        }
        catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
