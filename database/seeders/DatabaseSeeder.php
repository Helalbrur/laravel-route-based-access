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
use Database\Seeders\LibItemCategoryListSeeder;

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
            $user= User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password'=>Hash::make('12345678')
            ]);

            $this->call(LibItemCategoryListSeeder::class);
            $this->call(MainModuleSeeder::class);
            $this->call(MainMenuSeeder::class);
            $this->call(UserPrivModuleSeeder::class);
            $this->call(UserPrivMstSeeder::class);

            // $permision1=Permission::factory()->create([
            //     'name' => 'View Permission',
            //     'route_name' => 'permission.index',
            // ]);

            // $permision2=Permission::factory()->create([
            //     'name' => 'Save Permission',
            //     'route_name' => 'permission.store',
            // ]);
            // $permissionIdArr = array();
            // $permissionIdArr[$permision1->id]=$permision1->id;
            // $permissionIdArr[$permision2->id]=$permision2->id;
            // $user->permissions()->sync($permissionIdArr);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
