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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'products'], function () {
    Route::get('/', 'Stock\ProductsController@index')->name('products.index');
    Route::get('/create', 'Stock\ProductsController@create')->name('products.create');
    Route::get('{product}/product-details/', 'Stock\ProductsController@show')->name('products.show');
    Route::post('/save-product', 'Stock\ProductsController@save')->name('products.save');
    Route::get('get-products', 'Stock\ProductsController@getData')->name('products.get_data');

    Route::group(['prefix' => 'stock'], function () {
        Route::get('/', 'Stock\StockController@index')->name('stock.index');
        Route::get('{product}/add', 'Stock\StockController@create')->name('stock.create');
        Route::post('{product}/save-stock', 'Stock\StockController@store')->name('stock.save');
    });
});
Route::group(['prefix' => 'suppliers'], function () {
    Route::get('/', 'Suppliers\SuppliersController@index')->name('suppliers.index');
    Route::get('create', 'Suppliers\SuppliersController@create')->name('suppliers.create');
    Route::post('create', 'Suppliers\SuppliersController@store')->name('suppliers.save');
});
Route::group(['prefix' => 'categories'], function () {
    Route::get('/', 'CategoriesController@index')->name('categories.index');
    Route::get('create', 'CategoriesController@create')->name('categories.create');
    Route::post('save-category', 'CategoriesController@store')->name('categories.save');
    Route::get('get-categories', 'CategoriesController@getData')->name('categories.get_data');
});
Route::group(['prefix' => 'settings'], function () {
    Route::get('/', function () {
    })->name('settings.index');
});
Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'UsersController@index')->name('users.index');
});

Route::group(['prefix' => 'invoices'], function () {
    Route::get('search', 'Inventory\InvoicesController@search')->name('invoices.search');
});
