<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

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

Route::get('{any}', function () {
    return view('layouts.index');
})->where('any', '.*');


Route::prefix("auth")->group(function () {
    Route::post("login", "AuthController@login");
    Route::post("register", "AuthController@register");
    Route::post("logout", "AuthController@logout");
});


Route::prefix("dashboard")->group(function() {
    Route::prefix("users")->group(function () {
        Route::post("data", "UserController@get");
        Route::post("update", "UserController@update");
    });

    Route::prefix("departments")->group(function () {
        Route::post("create", "DepartmentController@create");
        Route::post("update", "DepartmentController@update");
    });
});


/*Route::post('product/create','ProductController@store');
Route::resource('product', 'ProductController')->except('index');

 Auth::routes();

Route::get('/users/{id}','UserController@index');

Route::middleware(['auth', 'employee'])->group(function () {
    Route::get('/dashboard','DashboardController@index');
});
*/
