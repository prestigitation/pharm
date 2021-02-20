<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::post('product/create','ProductController@store');
Route::resource('product', 'ProductController')->except('index');

Auth::routes();

Route::prefix('dashboard')->middleware(['auth','employee'])->group(function () {
       Route::get('/info','DashboardController@info');
       Route::get('/','DashboardController@index');
});

