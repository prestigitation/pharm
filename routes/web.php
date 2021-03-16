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

Route::view('{any}', 'layouts.index')->where('any', '.*');


Route::prefix("auth")->group(function () {
    Route::post("login", "AuthController@login");
    Route::post("register", "AuthController@register");
    Route::post("logout", "AuthController@logout");
});


Route::prefix("dashboard")->group(function() {
    Route::prefix("users")->group(function () {
       Route::post("create", "UserController@get");
       Route::post("update", "UserController@update");
    });

    Route::prefix("departments")->group(function () {
        Route::post("create", "DepartmentController@create");
        Route::post("products", "DepartmentController@productAdd");
        Route::post("department_info", "DepartmentController@departmentInfo");
        Route::post("update", "DepartmentController@update");
        Route::post("delete", "DepartmentController@destroy");
    });

    Route::prefix("products")->group(function () {
        Route::post("create", "ProductController@create");
        Route::post("categories", "ProductController@getCategories");
        Route::post("products", "ProductController@get");
        Route::post("update", "ProductController@update");
        Route::post("delete","ProductController@delete");
    });

    Route::prefix("dealers")->group(function () {
        Route::post("create", "DealerController@add");
        Route::post("get","DealerController@get");
        Route::post("delete","DealerController@delete");
        Route::post("update", "DealerController@update");
    });
    Route::prefix("dealers")->group(function () {
        Route::post("create", "DealerController@add");
        Route::post("get","DealerController@get");
        Route::post("delete","DealerController@delete");
        Route::post("update", "DealerController@update");
    });

    Route::prefix("roles")->group(function () {
        Route::post("data", "RolesController@addRole");
        Route::post("get","RolesController@get");
        Route::post("attach","RolesController@delete");
        Route::post("update", "RolesController@update");
    });

    Route::prefix("permissions")->group(function () {
        Route::post("data", "PermissionsController@addPermission");
        Route::post("get","PermissionsController@get");
        Route::post("delete","PermissionsController@delete");
        Route::post("update", "PermissionsController@update");
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
