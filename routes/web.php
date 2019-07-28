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
AUth::routes(['verify'=>true]);


Route::group(['middleware' => 'auth', 'middleware'=>'verified'], function() 
{
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('admin/category/trash', 'CategoryController@trash')->name('category.trash');
    Route::get('admin/category/{id}/restore', 'CategoryController@restore')->name('category.restore');
    Route::delete('admin/category/{id}/deletepermanent', 'CategoryController@deletepermanent')->name('category.deletepermanent');
    Route::resource('admin/category', 'CategoryController'); 

    Route::get('admin/product/trash', 'ProductController@trash')->name('product.trash');
    Route::get('admin/product/{id}/restore', 'ProductController@restore')->name('product.restore');
    Route::delete('admin/product/{id}/deletepermanent', 'ProductController@deletepermanent')->name('product.deletepermanent');
    Route::resource('admin/product', 'ProductController');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('admin/role', 'RoleController');

        Route::get('admin/user/trash', 'UserController@trash')->name('user.trash');
        Route::get('admin/user/{id}/restore', 'UserController@restore')->name('user.restore');
        Route::delete('admin/user/{id}/deletepermanent', 'UserController@deletepermanent')->name('user.deletepermanent');
        Route::post('admin/user/permission', 'UserController@addPermission')->name('user.add_permission');
        Route::put('admin/user/roles/{id}', 'UserController@setRole')->name('user.set_role');
        Route::get('admin/user/role-permission', 'UserController@rolePermission')->name('user.role_permission');
        Route::put('admin/user/permission/{role}', 'UserController@setRolePermission')->name('user.setRolePermission');
        Route::resource('admin/user', 'UserController')->except([
            'show'
        ]);
        Route::get('admin/users/roles/{id}', 'UserController@roles')->name('user.roles'); 
    });

    

    
});


