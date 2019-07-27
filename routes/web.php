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

Auth::routes();


Route::group(['middleware' => 'auth'], function() 
{
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('admin/category/trash', 'CategoryController@trash')->name('category.trash');
    Route::get('admin/category/{id}/restore', 'CategoryController@restore')->name('category.restore');
    Route::delete('admin/category/{id}/deletepermanent', 'CategoryController@deletepermanent')->name('category.deletepermanent');
    Route::resource('admin/category', 'CategoryController'); 

    Route::resource('admin/product', 'ProductController');
});


