<?php

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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return view('layouts.adminDashboard');
        })->name('adminDashboard');
    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //users
    Route::group(['middleware' => ['role_or_permission:SuperAdmin|Role-Management']], function () {
        Route::get('/get-users', [\App\Http\Controllers\UserController::class, 'getUsers'])->name('get.users');
        Route::resource('/users', \App\Http\Controllers\UserController::class);
    });
    //roles
    Route::resource('/roles', \App\Http\Controllers\RoleController::class)->middleware(['role_or_permission:SuperAdmin|Role-Management']);
    //permissions
    Route::resource('/permissions', \App\Http\Controllers\PermissionController::class)->middleware(['role_or_permission:SuperAdmin|Permissions-Management']);
});

require __DIR__.'/auth.php';
