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

// Home
Route::get('/', 'HomeController@index')->name('home');

// Items
Route::get('/item', 'ItemController@index')->name('add');
Route::post('/item', 'ItemController@create');
Route::patch('/item/{id}', 'ItemController@patch');
Route::delete('/item/{id}', 'ItemController@delete');
