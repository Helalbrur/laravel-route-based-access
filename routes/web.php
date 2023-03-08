<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Protected routes

Route::middleware(['auth'])->group(function () {
    Route::middleware(['CheckPermission:View Permission'])->group(function () {
        Route::get('/permission', [PermissionController::class,'index'])->name('permission.index');
    });
    Route::middleware(['CheckPermission:Save Permission'])->group(function () {
        Route::post('/permission',[PermissionController::class,'store'])->name('permission.store');
    });
});

// Route::middleware(['auth','CheckPermission'])->group(function () {
//     Route::get('/permission',[PermissionController::class,'index'])->name('permission.index')->middleware('permission:View Permission');
    
// });

// Route::middleware(['auth'])->group(function () {
//     Route::middleware(['permission:View Permission', 'CheckPermission'])->group(function () {
//         Route::get('/permission', [PermissionController::class,'index'])->name('permission.index');
//     });
//     Route::middleware(['permission:Save Permission', 'CheckPermission'])->group(function () {
//         Route::post('/permission',[PermissionController::class,'store'])->name('permission.store');
//     });
    
// });


require __DIR__.'/auth.php';
