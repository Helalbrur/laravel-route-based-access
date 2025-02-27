<?php

use App\Models\LibUom;
use App\Models\LibBrand;
use App\Models\ImageUpload;
use App\Models\UserPrivMst;
use App\Models\LibItemGroup;
use App\Models\LibItemSubGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\LibBinController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LibRackController;
use App\Http\Controllers\LibRoomController;
use App\Http\Controllers\LibSizeController;
use App\Http\Controllers\LibUomController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DbBackUpController;
use App\Http\Controllers\LibBrandController;
use App\Http\Controllers\LibBuyerController;
use App\Http\Controllers\LibColorController;
use App\Http\Controllers\LibFloorController;
use App\Http\Controllers\LibShelfController;
use App\Http\Controllers\MainMenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibCountryController;
use App\Http\Controllers\MainModuleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserImportController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\LibCategoryController;
use App\Http\Controllers\LibEmployeeController;
use App\Http\Controllers\LibGenericController; 
use App\Http\Controllers\LibLocationController;
use App\Http\Controllers\LibSupplierController;
use App\Http\Controllers\UserPrivMstController;
use App\Http\Controllers\FieldManagerController;
use App\Http\Controllers\LibItemGroupController;
use App\Http\Controllers\ReportSettingController;
use App\Http\Controllers\MandatoryFieldController;
use App\Http\Controllers\LibItemSubGroupController;
use App\Http\Controllers\FieldLevelAccessController;
use App\Http\Controllers\LibStoreLocationController;
use App\Http\Controllers\LibItemSubCategoryController;
use App\Http\Controllers\ProductDetailsMasterController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard',[DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/popup',[PermissionController::class,'popup'])->name('popup.open');
});
// Protected routes
//Tools route
Route::prefix('/tools')->middleware(['auth','PagePermission'])->group(function () {

    //permision route = > only admin user can access
    Route::resource('/create_menu', MainMenuController::class);
    Route::resource('/user_previledge', UserPrivMstController::class);
    Route::resource('/create_main_module', MainModuleController::class);
    Route::resource('/mandatory_field', MandatoryFieldController::class);
    Route::resource('/field_level_access', FieldLevelAccessController::class);
    Route::resource('/user_management', UserController::class);
    Route::resource('/field_manager',FieldManagerController::class);
});

Route::prefix('/lib')->middleware(['auth','PagePermission'])->group(function () {

    //permision route = > only admin user can access
    Route::resource('/company', CompanyController::class);
    Route::resource('/group', GroupController::class);
    Route::resource('/location', LibLocationController::class);
    Route::resource('/employee', LibEmployeeController::class);
    Route::resource('/supplier', LibSupplierController::class);
    Route::resource('/buyer', LibBuyerController::class);

    Route::resource('/inventory/floor', LibFloorController::class);
    Route::resource('/inventory/room', LibRoomController::class);
    Route::resource('/inventory/rack', LibRackController::class);
    Route::resource('/inventory/shelf', LibShelfController::class);
    Route::resource('/inventory/bin', LibBinController::class);

    Route::resource('/general/color', LibColorController::class);
    Route::resource('/general/uom', LibUomController::class);
    Route::resource('/general/generic', LibGenericController::class);
    Route::resource('/general/size', LibSizeController::class);
    Route::resource('/general/country', LibCountryController::class);
    Route::resource('/general/store', LibStoreLocationController::class);
    Route::resource('/general/brand', LibBrandController::class);
    Route::resource('/general/product_details_master', ProductDetailsMasterController::class);


    Route::resource('/variable_setting/report_setting', ReportSettingController::class);

    Route::resource('/item_details/item_category', LibCategoryController::class);
    Route::resource('/item_details/item_group', LibItemGroupController::class);
    Route::resource('/item_details/item_sub_group', LibItemSubGroupController::class);
    Route::resource('/item_details/item_sub_category', LibItemSubCategoryController::class);
});

Route::prefix('/tools')->middleware(['auth'])->group(function(){
    Route::get('mandatory_field_entry_form',[MandatoryFieldController::class,'entry_form_popup']);
    Route::get('load_drop_down_mandatory_field_item',[MandatoryFieldController::class,'load_drop_down_mandatory_field_item']);
    Route::get('mandatory_action_user_data',[MandatoryFieldController::class,'mandatory_action_user_data']);


    Route::get('field_manager_entry_form',[FieldManagerController::class,'entry_form_popup']);
    Route::get('load_drop_down_field_manager_item',[FieldManagerController::class,'load_drop_down_field_manager_item']);
    Route::get('field_manager_action_user_data',[FieldManagerController::class,'field_manager_action_user_data']);


    
    Route::get('field_level_access_user',[FieldLevelAccessController::class,'field_level_access_user']);
    Route::get('field_level_action_user_data',[FieldLevelAccessController::class,'field_level_action_user_data']);
    Route::get('load_drop_down_field_level_access',[FieldLevelAccessController::class,'load_drop_down_field_level_access']);
    Route::get('set_field_name',[FieldLevelAccessController::class,'set_field_name']);

});

Route::middleware(['auth'])->group(function () {
    Route::post('/populate_common_data',[CommonController::class,'populateCommonData']);
    Route::get('show_common_list_view',[CommonController::class,'show_common_list_view']);
    Route::get('common_file_popup',[CommonController::class,'common_file_popup']);
    Route::get('get_mandatory_and_field_level_data',[CommonController::class,'get_mandatory_and_field_level_data']);

    Route::get('get_field_manager_data',[CommonController::class,'get_field_manager_data']);


    Route::get('load_drop_down',[CommonController::class,'load_drop_down']);

    Route::delete('/file_delete/{id}', [ImageUploadController::class,'destroy']);


    Route::post('/tools/create_main_module/update', [MainModuleController::class,'create_main_module_update']);
    Route::get('/tools/create_main_module/get_data_by_id/{id}',[MainModuleController::class,'get_data_by_id']);
    Route::get('tools/create_menu/get_data_by_id/{id}',[MainMenuController::class,'get_data_by_id']);
    Route::get('/tools/show_module_list_view',[MainModuleController::class,'show_module_list_view']);
    Route::get('/tools/create_menu_search_list_view',[MainMenuController::class,'create_menu_search_list_view']);
    Route::get('tools/root_menu_under',[MainMenuController::class,'root_menu_under']);
    Route::get('tools/sub_root_menu_under',[MainMenuController::class,'sub_root_menu_under']);
    Route::get('tools/load_main_menu',[MainMenuController::class,'load_main_menu']);
    //Route::get('tools/load_available_route',[MainMenuController::class,'load_available_route']);
    Route::get('tools/load_sub_menu_under_menu',[MainMenuController::class,'load_sub_menu_under_menu']);
    Route::get('tools/load_priviledge_list',[UserPrivMstController::class,'load_priviledge_list']);
    Route::get('tools/load_priv_list_view',[UserPrivMstController::class,'load_priv_list_view']);
    Route::post('tools/copy_user_previledge',[UserPrivMstController::class,'copyUserPreviledge']);

    Route::get('lib/get_lib_group/{id}',[GroupController::class,'get_lib_group']);

    //permision route = > only admin user can access
    Route::middleware(['CheckPermission:View Permission'])->group(function () {
       Route::get('/permission', [PermissionController::class,'index'])->name('permission.index');
    });
    Route::middleware(['CheckPermission:Save Permission'])->group(function () {
       Route::post('/permission',[PermissionController::class,'store'])->name('permission.store');
    });

     //Button Click Database Backup route
     Route::resource('/db_backup',DbBackUpController::class);

    Route::get('/user_import', function () {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="user_import_template.csv"',
        ];

        $columns = ['Name', 'Email', 'Phone', 'Password']; // Adjust columns as needed
        $handle = fopen('php://output', 'w');
        fputcsv($handle, $columns);

        return Response::make(stream_get_contents($handle), 200, $headers);
    });

    Route::post('/user_import', [UserImportController::class, 'import'])->name('import');
    Route::post('/lib_buyer_import', [LibBuyerController::class, 'import'])->name('lib_buyer_import');
    Route::get('/lib_buyer_export', [LibBuyerController::class, 'export'])->name('lib_buyer_export');

    Route::post('/lib_supplier_import', [LibSupplierController::class, 'import'])->name('lib_supplier_import');
    Route::get('/lib_supplier_export', [LibSupplierController::class, 'export'])->name('lib_supplier_export');

    Route::get('/generate-bangla-pdf', [PdfController::class,'generatePdf']);
    Route::get('/html_content_export', [ReportController::class,'generateExcelFromHtmlContent']);


    Route::get('/room_details/{room_id}', [LibRoomController::class, 'load_details']);
    Route::get('/rack_details/{rack_id}', [LibRackController::class, 'load_details']);
    Route::get('/shelf_details/{shelf_id}', [LibShelfController::class, 'load_details']);
    Route::get('/bin_details/{bin_id}', [LibBinController::class, 'load_details']);

});



require __DIR__.'/auth.php';
