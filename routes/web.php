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

Route::get('voip-file/{secret}',"DownloadController@downloadFile")->name('voip-file-download');


Route::get('forgot-password', function(){
    return view("authentication.forgot-password");
})->name('forgot-password');

Route::middleware(['auth','preventBackHistory'])->group(function () {
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['prefix' => 'servers'], function () {
        Route::get('/','ServersController@index')->name('servers');
        Route::get('search/{query}',"ServersController@searchServer")->name('search-server');

    });

    Route::group(['prefix' => 'server'], function () {
         Route::get('{server_id}','ServersController@getServerFiles')->name('server');
        Route::get('{file_id}/secret','ServersController@generetSecret')->name('gen-secret');
        Route::get('{file_id}/download','ServersController@getDownloadFile')->name('download-file');

        Route::get('{file_id}/link',"ServersController@generateLink")->name('voip-link-download');

    });


    Route::get('config/server', function(){
        return view("admin.config.servers.servers");
    })->name('config.server');

    Route::resource('config/users', 'UserController');

    Route::group(['prefix' => 'logs'], function () {

        Route::get('/', "LogsController@index")->name('logs');
        Route::get('app', "LogsController@getAllLogApp")->name('logs-app');
        Route::get('file', "LogsController@getAllLogFile")->name('logs-file');

    });
});
