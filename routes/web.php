<?php

use App\Http\Controllers\PackageController;
use App\Http\Controllers\PopularPlaceController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return "Welcome to Go Hotel Management System API with admin panel...";
});

Route::get('/login', [IndexController::class, 'loginPage']);

Route::get('/admin/login', [IndexController::class, 'loginPage'])->name('login-admin');

Route::post('admin-login', [AccessController::class, 'adminLogin']);

Route::get('/logout', [AccessController::class, 'Logout']);

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');

    return 'All caches (config, route, view & optimize application) have been cleared!';
});

Route::middleware(['prevent-back-history', 'admin_auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'Dashboard'])->name('dashboard');

    Route::resource('packages', PackageController::class);
    Route::resource('popularPlaces', PopularPlaceController::class);
    Route::resource('withdraws', WithdrawController::class);

    # web routes
    Route::resource('propertyTypes', PropertyTypeController::class);
});


//Route::group(['middleware' => ['web', 'prevent-back-history', 'admin_auth']], function () {
//    // admin dashboard
//    Route::get('/dashboard', [DashboardController::class, 'Dashboard']);
//});
