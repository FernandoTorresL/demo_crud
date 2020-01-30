<?php

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

Route::group(['prefix' => 'laravel-crud-image-gallery'], function () {
    Route::get('/', 'Crud4Controller@index');
    Route::match(['get', 'post'], 'create', 'Crud4Controller@create');
    Route::match(['get', 'put'], 'update/{id}', 'Crud4Controller@update');
    Route::delete('delete/{id}', 'Crud4Controller@delete');
});
