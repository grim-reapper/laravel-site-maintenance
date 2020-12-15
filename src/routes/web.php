<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['web']], function () {
    Route::prefix(config('grimreapper.route_prefix'))->name(config('grimreapper.route_prefix').'.')->group(function(){
        Route::group(['namespace' => 'GrimReapper\LaravelSiteMaintenance\Http\Controllers'], function(){
            Route::get('system/maintenance', 'MaintenanceModeController@index')->name('maintenance');
            Route::post('system/maintenance', 'MaintenanceModeController@run')->name('system.maintenance.run');
        });
    });
});
