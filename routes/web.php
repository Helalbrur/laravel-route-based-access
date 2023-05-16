<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainMenuController;
use App\Http\Controllers\MainModuleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserPrivMstController;
use App\Models\UserPrivMst;
use Illuminate\Support\Facades\Route;

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
});

Route::middleware(['auth'])->group(function () {
    Route::post('/tools/create_main_module/update', [MainModuleController::class,'create_main_module_update']);
    Route::get('/tools/create_main_module/get_data_by_id/{id}',[MainModuleController::class,'get_data_by_id']);
    Route::get('tools/create_menu/get_data_by_id/{id}',[MainMenuController::class,'get_data_by_id']);
    Route::get('/tools/show_module_list_view',[MainModuleController::class,'show_module_list_view']);
    Route::get('/tools/create_menu_search_list_view',[MainMenuController::class,'create_menu_search_list_view']);
    Route::get('tools/root_menu_under',[MainMenuController::class,'root_menu_under']);
    Route::get('tools/sub_root_menu_under',[MainMenuController::class,'sub_root_menu_under']);
    Route::get('tools/load_priviledge_list',[UserPrivMstController::class,'load_priviledge_list']);
    //permision route = > only admin user can access
    Route::middleware(['CheckPermission:View Permission'])->group(function () {
       Route::get('/permission', [PermissionController::class,'index'])->name('permission.index');
    });
    Route::middleware(['CheckPermission:Save Permission'])->group(function () {
       Route::post('/permission',[PermissionController::class,'store'])->name('permission.store');
    });
});



require __DIR__.'/auth.php';
