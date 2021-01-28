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


Auth::routes();
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::post('loginuser', 'Auth\LoginController@adminLogin')->name('loginuser');


Route::get('forgot-password', function(){
    return view("authentication.forgot-password");
})->name('forgot-password');

Route::middleware(['auth','preventBackHistory'])->group(function () {
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('servers','ServersController@index')->name('servers');
    Route::get('server/{server_path}','ServersController@getServerFiles')->name('server');

    Route::get('config/server', function(){
        return view("admin.config.servers.servers");
    })->name('config.server');

    Route::get('config/users', function(){
        return view("admin.config.users.users");
    })->name('config.users');

    Route::get('logs', function(){
        return view("admin.logs.log");
    })->name('logs');
});