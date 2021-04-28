<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::namespace('Api')->group(function () {
    Route::apiResource('users', 'UsersController');
    Route::apiResource('roles', 'RolesController');
    Route::apiResource('products', 'ProductsController');
    Route::apiResource('categories', 'CategoriesController');
    Route::apiResource('dealers', 'DealersController');
    Route::apiResource('departments', 'DepartmentsController');
    Route::apiResource('permissions', 'PermissionsController');
    Route::apiResource('statuses', 'StatusesController');
    Route::apiResource('workers', 'WorkersController');
    Route::apiResource('news', 'NewsController');

    Route::post('/{section}/{id}/file', 'FileController@updateFile');
    Route::post('/departments/products', 'DepartmentsController@productAdd');
    Route::post('/roles/{id}/permissions', 'RolesController@permissionsAttach');
    Route::post('/users/{id}/roles', 'UsersController@rolesAttach');
    Route::get('/users/{id}/permissions','UsersController@permissionsGet');
    Route::get('/users/{id}/roles', 'UsersController@rolesGet');
    Route::get('/products/{id}/departments','ProductsController@getDepartments');
    Route::get('/storage', 'FileController@getStoragePath');
    Route::post('/products/search','ProductsController@find');
    Route::post('/products/departments','ProductsController@addOrder');
    Route::get('/roles/{id}/permissions', 'RolesController@permissionsGet');
    Route::delete('/roles/{name}/permissions', 'RolesController@permissionsDetach');
    Route::delete('/users/{id}/roles', 'UsersController@rolesDetach');
    Route::post('/filter','ProductsController@filter');


});
