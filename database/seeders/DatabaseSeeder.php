<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Exception;
use App\Models\User;
use App\Models\MainMenu;
use App\Models\MainModule;
use App\Models\Permission;
use App\Models\UserPrivMst;
use App\Models\UserPrivModule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\MainMenuSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\MainModuleSeeder;
use Database\Seeders\LibCategorySeeder;
use Database\Seeders\UserPrivMstSeeder;
use Database\Seeders\UserPrivModuleSeeder;

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
               $admin = User::factory()->create([
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'password'=>Hash::make('12345678')
                ]);

                $helal = User::factory()->create([
                    'name' => 'Helal Uddin',
                    'email' => 'helal@gmail.com',
                    'password'=>Hash::make('12345678')
                ]);

                // Create MainModules
                $lib_module = MainModule::create(['m_mod_id' => 1,'main_module' => 'Lib','status' => 1,'mod_slno' => 1]);
                //Order module
                $order_module = MainModule::create(['m_mod_id' => 2,'main_module' => 'Order Management','status' => 1,'mod_slno' => 2]);
                //TNA module
                $tna_module = MainModule::create(['m_mod_id' => 3,'main_module' => 'TNA','status' => 1,'mod_slno' => 3]);
                //plan module
                $plan_module = MainModule::create(['m_mod_id' => 4,'main_module' => 'Plan','status' => 1,'mod_slno' => 4]);
                //Commercial module
                $commercial_module = MainModule::create(['m_mod_id' => 5,'main_module' => 'Commercial','status' => 1,'mod_slno' => 5]);
                //invetory module
                $inventory_module = MainModule::create(['m_mod_id' => 6,'main_module' => 'Inventory','status' => 1,'mod_slno' => 6]);
                //Production module
                $production_module = MainModule::create(['m_mod_id' => 7,'main_module' => 'Production','status' => 1,'mod_slno' => 7]);
                //Subcontract module
                $subcontract_module = MainModule::create(['m_mod_id' => 8,'main_module' => 'Subcontract','status' => 1,'mod_slno' => 8]);
                //Sample module
                $sample_module = MainModule::create(['m_mod_id' => 9,'main_module' => 'Sample','status' => 1,'mod_slno' => 9]);
                //SCM module
                $scm_module = MainModule::create(['m_mod_id' => 10,'main_module' => 'SCM','status' => 1,'mod_slno' => 10]);
                //Report module
                $report_module = MainModule::create(['m_mod_id' => 11,'main_module' => 'Report','status' => 1,'mod_slno' => 11]);
                
                //Admin module
                $admin_module = MainModule::create(['m_mod_id' => 12,'main_module' => 'Admin','status' => 1,'mod_slno' => 12]);

               
                $menu_arr =
                [
                    [1, 5, 10, 0, 0, 'Menu Management', 'tools/create_menu', 'create_menu', 0, 1, 1, 2, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [2, 4, 10, 0, 0, 'Module Management', 'tools/create_main_module', 'tools.create_main_module', 0, 1, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [3, 3, 10, 0, 0, 'Privilege Management', 'tools/user_previledge', 'tools.user_previledge', 113, 1, 1, 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL],
                    [4, 6, 1, 8, 0, 'Company', 'lib/company', NULL, 113, 2, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [5, 7, 1, 0, 0, 'General', '', NULL, 113, 1, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [8, 8, 1, 0, 0, 'Cost Center', '', NULL, 113, 1, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [9, 9, 1, 8, 0, 'Group Profile', 'lib/group', NULL, 113, 2, 1, 0, 0, 0, NULL, NULL, 2, NULL, NULL, NULL, 1, 0, NULL],
                    [11, 11, 1, 7, 0, 'Color Entry', 'lib/general/color', NULL, 0, 2, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [13, 12, 1, 7, 0, 'Size Entry', 'lib/general/size', NULL, 0, 2, 1, 2, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [14, 13, 1, 7, 0, 'Country Entry', 'lib/general/country', NULL, 0, 2, 1, 3, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [15, 14, 1, 0, 0, 'Item Details', '', NULL, 0, 1, 1, 3, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [16, 15, 1, 14, 0, 'Item Category List', 'lib/item_details/item_category', NULL, 0, 2, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [17, 16, 1, 14, 0, 'Item Group', 'lib/item_details/item_group', NULL, 0, 2, 1, 2, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [18, 17, 1, 14, 0, 'Item Sub Group', 'lib/item_details/item_sub_group', NULL, 0, 2, 1, 4, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [19, 18, 10, 0, 0, 'Mandatory Field', 'tools/mandatory_field', NULL, 0, 1, 1, 4, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [20, 19, 10, 0, 0, 'Field Level Access', 'tools/field_level_access', NULL, 0, 1, 1, 5, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [21, 20, 10, 0, 0, 'Manual Database Backup', 'db_backup', NULL, 0, 1, 1, 6, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [22, 21, 1, 8, 0, 'Location', 'lib/location', NULL, 0, 2, 1, 3, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [23, 22, 1, 0, 0, 'Contact Details', '', NULL, 0, 1, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [24, 23, 1, 22, 0, 'Buyer Profile', 'lib/buyer', NULL, 0, 2, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [25, 24, 1, 22, 0, 'Supplier Profile', 'lib/supplier', NULL, 0, 2, 1, 2, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [26, 25, 1, 0, 0, 'Inventory', '', NULL, 0, 1, 1, 5, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [27, 26, 1, 25, 0, 'Floor Setup', 'lib/inventory/floor', NULL, 0, 2, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [28, 27, 1, 25, 0, 'Room', 'lib/inventory/room', NULL, 0, 2, 1, 2, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [29, 28, 1, 25, 0, 'Rack', 'lib/inventory/rack', NULL, 0, 2, 1, 3, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [30, 29, 1, 25, 0, 'Shelf', 'lib/inventory/shelf', NULL, 0, 2, 1, 4, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [31, 30, 1, 25, 0, 'Bin', 'lib/inventory/bin', NULL, 0, 2, 1, 5, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [32, 31, 1, 7, 0, 'Store Location', 'lib/general/store', NULL, 0, 2, 1, 4, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [33, 32, 10, 0, 0, 'User Management', 'tools/user_management', NULL, 0, 1, 1, 7, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [34, 33, 1, 0, 0, 'Variable Setting', '', NULL, 0, 1, 1, 5, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [35, 34, 1, 33, 0, 'Report Setting', 'lib/variable_setting/report_setting', NULL, 0, 2, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [36, 35, 1, 7, 0, 'Brand Entry', 'lib/general/brand', NULL, 0, 2, 1, 5, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [37, 36, 1, 7, 0, 'Generic', 'lib/general/generic', NULL, 0, 2, 1, 6, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [38, 37, 1, 22, 0, 'Employee', 'lib/employee', NULL, 0, 2, 1, 3, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [39, 38, 1, 7, 0, 'Item Creation', 'lib/general/product_details_master', NULL, 0, 2, 1, 6, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [40, 39, 10, 0, 0, 'Field Manager', 'tools/field_manager', NULL, 0, 1, 1, 7, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [41, 40, 1, 7, 0, 'Uom', 'lib/general/uom', NULL, 0, 2, 1, 8, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [42, 41, 1, 14, 0, 'Sub Category', 'lib/item_details/item_sub_category', NULL, 0, 2, 1, 4, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [43, 42, 11, 0, 0, 'Order', '', NULL, 0, 1, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [44, 43, 11, 0, 0, 'Report', '', NULL, 0, 1, 1, 2, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL],
                    [45, 44, 11, 42, 0, 'Work Order', 'order/work_order', NULL, 0, 2, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL]
                ];

                $moduleMapping = [
                    10 => $admin_module->m_mod_id,
                    1  => $lib_module->m_mod_id,
                    11 => $order_module->m_mod_id
                ];

                $newMenuIdArr = array();

                $newMenuArr= array();
                
                foreach ($menu_arr as $data) {
                    if($data[1] == 2) $user = $helal;
                    else $user = $admin;
                    //(`id`, `m_menu_id`, `m_module_id`, `root_menu`, `sub_root_menu`, `menu_name`, `f_location`, `route_name`, `fabric_nature`, `position`, `status`, `slno`, `report_menu`, `is_mobile_menu`, `m_page_name`, `m_page_short_name`, `inserted_by`, `insert_date`, `updated_by`, `update_date`, `status_active`, `is_deleted`, `deleted_at`)
                    $menu = [
                        'm_module_id' => $moduleMapping[$data[2]] ?? null,
                        // 'm_menu_id' => $data[1],
                        'root_menu' => $data[3],
                        'sub_root_menu' => $data[4],
                        'menu_name' => $data[5],
                        'f_location' => $data[6],
                        'route_name' => $data[7],
                        'fabric_nature' => $data[8],
                        'position' => $data[9],
                        'status' => $data[10],
                        'slno' => $data[11],
                        'report_menu' => $data[12],
                        'is_mobile_menu' => $data[13],
                        'm_page_name' => $data[14],
                        'm_page_short_name' => $data[15],
                        'inserted_by' => $user->id,
                        'insert_date' => $data[17],
                        'updated_by' => $data[18],
                        'update_date' => $data[19],
                        'status_active' => $data[20],
                        'is_deleted' => $data[21],
                        'deleted_at' => $data[22]
                    ];
                    $newMenuArr[] = $menu;
                
                    $newMenu= MainMenu::create($menu);
                    $newMenuIdArr[$data[1]] = $newMenu->m_menu_id;

                   
                }

               // throw new Exception('new menu : '.json_encode($newMenuArr, JSON_PRETTY_PRINT));

                $menuPrivModuleArr = [
                    [1, 1, 10, NULL, 1, NULL, '2023-06-24 03:23:52', '2023-06-24 03:23:52'],
                    [2, 1, 1, NULL, 1, NULL, '2023-06-24 03:23:52', '2023-06-24 03:23:52'],
                    [5, 2, 10, NULL, 1, NULL, '2023-06-29 03:33:08', '2023-06-29 03:33:08'],
                    [4, 2, 1, NULL, 1, NULL, '2023-06-26 02:20:46', '2023-06-26 02:20:46'],
                    [6, 0, 1, NULL, 1, NULL, '2025-02-08 12:55:03', '2025-02-08 12:55:03'],
                    [7, 3, 1, NULL, 1, NULL, '2025-02-08 12:55:03', '2025-02-08 12:55:03'],
                    [8, 1, 11, NULL, 1, NULL, '2025-03-06 23:06:54', '2025-03-06 23:06:54']
                ];

                $moduleNewPrivArr = array();

                foreach ($menuPrivModuleArr as $data) {
                   
                   if($data[1] == 1) $user = $admin;
                   else if($data[1] == 2) $user = $helal;
                   else continue;

                   //(`id`, `user_id`, `module_id`, `user_only`, `valid`, `entry_date`, `created_at`, `updated_at`)

                   $newModulePriv = UserPrivModule::create([
                        'user_id' =>  $user->id,
                        'module_id' => $moduleMapping[$data[2]],
                        'user_only' => $data[3],
                        'valid' => $data[4],
                        'entry_date' => $data[5],
                        'entry_date' => $data[6],
                        'updated_at' => $data[7]
                    ]);

                    $moduleNewPrivArr[$data[2]] = $newModulePriv->module_id;
                }

                $menuPrivMstArr = [
                    [1, 1, 3, 1, 1, 1, 1, 1, 0, NULL, NULL, NULL, 1, 0, '2023-06-24 03:23:52', '2023-06-24 03:23:52'],
                    [2, 1, 4, 1, 1, 1, 1, 1, 0, NULL, NULL, NULL, 1, 0, '2023-06-24 03:23:52', '2023-06-24 03:23:52'],
                    [3, 1, 5, 1, 1, 1, 1, 1, 0, NULL, NULL, NULL, 1, 0, '2023-06-24 03:23:52', '2023-06-24 03:23:52'],
                    [19, 1, 9, 1, 1, 1, 1, 1, 1687737600, NULL, NULL, '2', 1, 0, '2023-06-26 10:25:55', '2023-06-26 10:25:55'],
                    [33, 1, 12, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 10:41:12', '2023-06-28 10:41:12'],
                    [11, 1, 6, 1, 1, 1, 1, 1, 1687737600, NULL, NULL, '1', 1, 0, '2023-06-26 01:14:22', '2023-06-26 01:14:22'],
                    [37, 1, 13, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 11:30:41', '2023-06-28 11:30:41'],
                    [35, 2, 12, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 10:41:12', '2023-06-28 10:41:12'],
                    [66, 1, 21, 1, 1, 1, 1, 1, 1700179200, NULL, NULL, '1', 1, 0, '2023-11-17 10:50:03', '2023-11-17 10:50:03'],
                    [91, 1, 31, 1, 1, 1, 1, 1, 1700870400, NULL, NULL, '1', 1, 0, '2023-11-25 00:52:28', '2023-11-25 00:52:28'],
                    [17, 2, 6, 1, 1, 1, 1, 1, 1687737600, NULL, NULL, '1', 1, 0, '2023-06-26 02:20:46', '2023-06-26 02:20:46'],
                    [65, 1, 8, 1, 1, 1, 1, 1, 1700179200, NULL, NULL, '1', 1, 0, '2023-11-17 10:50:03', '2023-11-17 10:50:03'],
                    [25, 2, 9, 1, 2, 1, 2, 2, 1687824000, NULL, NULL, '2', 1, 0, '2023-06-27 01:01:15', '2023-06-27 01:01:15'],
                    [27, 2, 10, 1, 2, 2, 2, 2, 1687824000, NULL, NULL, '2', 1, 0, '2023-06-27 01:03:19', '2023-06-27 01:03:19'],
                    [29, 1, 11, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 08:36:32', '2023-06-28 08:36:32'],
                    [99, 0, 35, 1, 1, 1, 1, 1, 1738972800, NULL, NULL, '1', 1, 0, '2025-02-08 12:55:03', '2025-02-08 12:55:03'],
                    [61, 2, 11, 1, 2, 1, 2, 2, 1690329600, NULL, NULL, '1', 1, 0, '2023-07-26 10:55:04', '2023-07-26 10:55:04'],
                    [39, 2, 13, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 11:30:41', '2023-06-28 11:30:41'],
                    [43, 2, 15, 1, 1, 1, 1, 1, 1687996800, NULL, NULL, '1', 1, 0, '2023-06-29 03:35:44', '2023-06-29 03:35:44'],
                    [47, 1, 16, 1, 1, 1, 1, 1, 1687996800, NULL, NULL, '1', 1, 0, '2023-06-29 06:05:06', '2023-06-29 06:05:06'],
                    [57, 2, 17, 1, 2, 2, 2, 2, 1688083200, NULL, NULL, '1', 1, 0, '2023-06-30 00:38:34', '2023-06-30 00:38:34'],
                    [45, 1, 15, 1, 1, 1, 1, 1, 1687996800, NULL, NULL, '1', 1, 0, '2023-06-29 03:35:44', '2023-06-29 03:35:44'],
                    [56, 2, 14, 1, 2, 2, 2, 2, 1688083200, NULL, NULL, '1', 1, 0, '2023-06-30 00:38:34', '2023-06-30 00:38:34'],
                    [49, 2, 16, 1, 1, 1, 1, 1, 1687996800, NULL, NULL, '1', 1, 0, '2023-06-29 06:05:06', '2023-06-29 06:05:06'],
                    [116, 1, 17, 1, 1, 1, 1, 1, 1740614400, NULL, NULL, '1', 1, 0, '2025-02-27 09:44:24', '2025-02-27 09:44:24'],
                    [117, 1, 14, 1, 1, 1, 1, 1, 1740614400, NULL, NULL, '1', 1, 0, '2025-02-27 10:54:37', '2025-02-27 10:54:37'],
                    [58, 2, 18, 1, 1, 1, 1, 1, 1688083200, NULL, NULL, '1', 1, 0, '2023-06-30 02:01:40', '2023-06-30 02:01:40'],
                    [59, 1, 18, 1, 1, 1, 1, 1, 1688083200, NULL, NULL, '1', 1, 0, '2023-06-30 02:01:40', '2023-06-30 02:01:40'],
                    [62, 1, 19, 1, 1, 1, 1, 1, 1697241600, NULL, NULL, '1', 1, 0, '2023-10-14 02:18:31', '2023-10-14 02:18:31'],
                    [63, 1, 20, 1, 1, 1, 1, 1, 1700179200, NULL, NULL, '1', 1, 0, '2023-11-16 23:50:38', '2023-11-16 23:50:38'],
                    [64, 2, 20, 1, 1, 1, 1, 1, 1700179200, NULL, NULL, '1', 1, 0, '2023-11-16 23:50:38', '2023-11-16 23:50:38'],
                    [67, 2, 8, 1, 1, 1, 1, 1, 1700179200, NULL, NULL, '1', 1, 0, '2023-11-17 10:50:03', '2023-11-17 10:50:03'],
                    [68, 2, 21, 1, 1, 1, 1, 1, 1700179200, NULL, NULL, '1', 1, 0, '2023-11-17 10:50:03', '2023-11-17 10:50:03'],
                    [108, 1, 22, 1, 1, 1, 1, 1, 1740182400, NULL, NULL, '1', 1, 0, '2025-02-21 23:41:29', '2025-02-21 23:41:29'],
                    [71, 1, 23, 1, 1, 1, 1, 1, 1700265600, NULL, NULL, '1', 1, 0, '2023-11-18 10:29:47', '2023-11-18 10:29:47'],
                    [73, 1, 24, 1, 1, 1, 1, 1, 1700784000, NULL, NULL, '1', 1, 0, '2023-11-24 12:19:20', '2023-11-24 12:19:20'],
                    [81, 1, 26, 1, 1, 1, 1, 1, 1700784000, NULL, NULL, '1', 1, 0, '2023-11-24 13:17:33', '2023-11-24 13:17:33'],
                    [83, 1, 27, 1, 1, 1, 1, 1, 1700784000, NULL, NULL, '1', 1, 0, '2023-11-24 13:17:40', '2023-11-24 13:17:40'],
                    [85, 1, 28, 1, 1, 1, 1, 1, 1700784000, NULL, NULL, '1', 1, 0, '2023-11-24 13:17:46', '2023-11-24 13:17:46'],
                    [87, 1, 29, 1, 1, 1, 1, 1, 1700784000, NULL, NULL, '1', 1, 0, '2023-11-24 13:17:51', '2023-11-24 13:17:51'],
                    [89, 1, 30, 1, 1, 1, 1, 1, 1700784000, NULL, NULL, '1', 1, 0, '2023-11-24 13:17:56', '2023-11-24 13:17:56'],
                    [88, 1, 25, 1, 1, 1, 1, 1, 1700784000, NULL, NULL, '1', 1, 0, '2023-11-24 13:17:56', '2023-11-24 13:17:56'],
                    [98, 0, 7, 1, 1, 1, 1, 1, 1738972800, NULL, NULL, '1', 1, 0, '2025-02-08 12:55:03', '2025-02-08 12:55:03'],
                    [93, 2, 31, 1, 1, 1, 1, 1, 1700870400, NULL, NULL, '1', 1, 0, '2023-11-25 00:52:28', '2023-11-25 00:52:28'],
                    [94, 1, 32, 1, 1, 1, 1, 1, 1702598400, NULL, NULL, '1', 1, 0, '2023-12-14 23:16:17', '2023-12-14 23:16:17'],
                    [96, 1, 33, 1, 1, 1, 1, 1, 1702684800, NULL, NULL, '1', 1, 0, '2023-12-15 21:53:45', '2023-12-15 21:53:45'],
                    [97, 1, 34, 1, 1, 1, 1, 1, 1702684800, NULL, NULL, '1', 1, 0, '2023-12-15 21:53:45', '2023-12-15 21:53:45'],
                    [120, 1, 38, 1, 1, 1, 1, 1, 1740614400, NULL, NULL, '1', 1, 0, '2025-02-27 11:16:27', '2025-02-27 11:16:27'],
                    [101, 1, 35, 1, 1, 1, 1, 1, 1738972800, NULL, NULL, '1', 1, 0, '2025-02-08 12:55:03', '2025-02-08 12:55:03'],
                    [102, 2, 7, 1, 1, 1, 1, 1, 1738972800, NULL, NULL, '1', 1, 0, '2025-02-08 12:55:03', '2025-02-08 12:55:03'],
                    [103, 2, 35, 1, 1, 1, 1, 1, 1738972800, NULL, NULL, '1', 1, 0, '2025-02-08 12:55:03', '2025-02-08 12:55:03'],
                    [104, 3, 7, 1, 1, 1, 1, 1, 1738972800, NULL, NULL, '1', 1, 0, '2025-02-08 12:55:03', '2025-02-08 12:55:03'],
                    [105, 3, 35, 1, 1, 1, 1, 1, 1738972800, NULL, NULL, '1', 1, 0, '2025-02-08 12:55:03', '2025-02-08 12:55:03'],
                    [107, 1, 36, 1, 1, 1, 1, 1, 1740182400, NULL, NULL, '1', 1, 0, '2025-02-21 23:37:49', '2025-02-21 23:37:49'],
                    [109, 1, 37, 1, 1, 1, 1, 1, 1740182400, NULL, NULL, '1', 1, 0, '2025-02-21 23:41:29', '2025-02-21 23:41:29'],
                    [119, 1, 7, 1, 1, 1, 1, 1, 1740614400, NULL, NULL, '1', 1, 0, '2025-02-27 11:16:27', '2025-02-27 11:16:27'],
                    [112, 1, 39, 1, 1, 1, 1, 1, 1740182400, NULL, NULL, '1', 1, 0, '2025-02-22 13:13:19', '2025-02-22 13:13:19'],
                    [114, 1, 40, 1, 1, 1, 1, 1, 1740614400, NULL, NULL, '1', 1, 0, '2025-02-27 09:41:28', '2025-02-27 09:41:28'],
                    [118, 1, 41, 1, 1, 1, 1, 1, 1740614400, NULL, NULL, '1', 1, 0, '2025-02-27 10:54:37', '2025-02-27 10:54:37'],
                    [121, 1, 42, 1, 1, 1, 1, 1, 1741305600, NULL, NULL, '1', 1, 0, '2025-03-06 23:06:54', '2025-03-06 23:06:54'],
                    [122, 1, 44, 1, 1, 1, 1, 1, 1741305600, NULL, NULL, '1', 1, 0, '2025-03-06 23:06:54', '2025-03-06 23:06:54'],
                    [123, 1, 43, 1, 1, 1, 1, 1, 1741305600, NULL, NULL, '1', 1, 0, '2025-03-06 23:07:02', '2025-03-06 23:07:02']
                ];



                foreach ($menuPrivMstArr as $data) {
                    if($data[1] == 1) $user = $admin;
                    else if($data[1] == 2) $user = $helal;
                    else continue;
                    if(!array_key_exists($data[2], $newMenuIdArr)) {
                        continue;
                        //throw new Exception("Menu{$data[2]} not found: " . json_encode($newMenuIdArr, JSON_PRETTY_PRINT));
                    }
                    $newMenuId = $newMenuIdArr[$data[2]];
                    //(`id`, `user_id`, `main_menu_id`, `show_priv`, `delete_priv`, `save_priv`, `edit_priv`, `approve_priv`, `entry_date`, `user_only`, `last_updated_by`, `inserted_by`, `valid`, `last_update_date`, `created_at`, `updated_at`)
                    $arr = [
                        'user_id' => $user->id,
                        'main_menu_id' => $newMenuId,
                        'show_priv' => $data[3],
                        'delete_priv' => $data[4],
                        'save_priv' => $data[5],
                        'edit_priv' => $data[6],
                        'approve_priv' => $data[7],
                        'entry_date' => $data[8],
                        'user_only' => $data[9],
                        'last_updated_by' => $data[10],
                        'inserted_by' => $data[11],
                        'valid' => $data[12],
                        'last_update_date' => $data[13],
                        'created_at' => $data[14],
                        'updated_at' => $data[15]
                    ];
                    //dd($arr);
                    $newMenuPriv = UserPrivMst::create($arr);
                   
                }

                DB::commit();
                echo "<pre>Database Seeding Successfully</pre>";
            }

        }
        catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage() . "\n" . $e->getLine() . "\n" . $e->getFile();// . "\n" . $e->getTraceAsString();
        }
    }
}
