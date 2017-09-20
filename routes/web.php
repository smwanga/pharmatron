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
    return redirect()->route('login');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'Stock\ProductsController@index')->name('products.index');
        Route::get('/create', 'Stock\ProductsController@create')->name('products.create');
        Route::get('{product}/product-details/', 'Stock\ProductsController@show')->name('products.show');
        Route::post('/save-product', 'Stock\ProductsController@save')->name('products.save');
        Route::get('get-products', 'Stock\ProductsController@getData')->name('products.get_data');
        Route::get('edit-product/{product}', 'Stock\ProductsController@edit')->name('products.edit');
        Route::get('product-barcodes/{product}', 'Stock\ProductsController@showBarcodes')->name('products.barcodes.show');
        Route::patch('update-product/{product}', 'Stock\ProductsController@update')->name('products.update');

        Route::group(['prefix' => 'stock'], function () {
            Route::get('/', 'Stock\StockController@index')->name('stock.index');
            Route::get('add', 'Stock\StockController@addStock')->name('stock.add');
            Route::get('show-stock/{stock}', 'Stock\StockController@viewStock')->name('stock.show');
            Route::get('edit-stock/{stock}', 'Stock\StockController@editStock')->name('stock.edit');
            Route::patch('update-stock/{stock}', 'Stock\StockController@updateStock')->name('stock.update');
            Route::get('{product}/add', 'Stock\StockController@create')->name('stock.create');
            Route::post('{product}/save-stock', 'Stock\StockController@store')->name('stock.save');
        });
    });
    Route::group(['prefix' => 'suppliers'], function () {
        Route::get('/', 'Suppliers\SuppliersController@index')->name('suppliers.index');
        Route::get('create', 'Suppliers\SuppliersController@create')->name('suppliers.create');
        Route::post('create', 'Suppliers\SuppliersController@store')->name('suppliers.save');
        Route::get('edit-profile/{supplier}', 'Suppliers\SuppliersController@edit')->name('suppliers.edit');
        Route::get('show-profile/{supplier}', 'Suppliers\SuppliersController@show')->name('suppliers.show');
        Route::patch('update-profile/{supplier}', 'Suppliers\SuppliersController@update')->name('suppliers.update');
    });
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoriesController@index')->name('categories.index');
        Route::get('create', 'CategoriesController@create')->name('categories.create');
        Route::post('save-category', 'CategoriesController@store')->name('categories.save');
        Route::get('get-categories', 'CategoriesController@getData')->name('categories.get_data');
    });
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'Settings\SettingsController@index')->name('settings.index');
        Route::get('email-settings', 'Settings\SettingsController@emailSettings')->name('settings.email');
        Route::get('create-config-item', 'Settings\SettingsController@createConfigItem')->name('settings.config.create');
        Route::post('save-config-item', 'Settings\SettingsController@saveConfigItem')->name('settings.config.save');
    });
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UsersController@index')->name('users.index');
        Route::get('create', 'UsersController@create')->name('users.create');
        Route::post('save-user', 'UsersController@store')->name('users.save');
    });

    Route::group(['prefix' => 'invoices'], function () {
        Route::get('search', 'Inventory\InvoicesController@search')->name('invoices.search');
    });
    Route::group(['prefix' => 'purchase-orders'], function () {
        Route::get('create', 'Inventory\InvoicesController@createPurchaseOrder')->name('purchase_order.create');
    });

    Route::group(['prefix' => 'sales'], function () {
        Route::get('/', 'Pos\PointOfSaleController@index')->name('sales');
        Route::get('make-sale/{sale?}', 'Pos\PointOfSaleController@create')->name('sales.index');
        Route::get('search', 'Pos\PointOfSaleController@searchItem')->name('sales.search');
        Route::post('add-item/{sale?}', 'Pos\PointOfSaleController@addItem')->name('sales.item.add');
        Route::post('update-item/{item}', 'Pos\PointOfSaleController@updateItem')->name('sales.item.update');
        Route::delete('delete-item/{item}', 'Pos\PointOfSaleController@deleteItem')->name('sales.item.delete');
        Route::post('update-sale/{sale}', 'Pos\PointOfSaleController@update')->name('sales.update');
        Route::get('sales-invoice/{sale}', 'Pos\PointOfSaleController@showInvoice')->name('sales.invoice');
        Route::get('sales-invoice/{sale}/pay', 'Pos\PointOfSaleController@showPayInvoice')->name('sales.invoice.pay');
        Route::post('sales-invoice/{sale}/pay', 'Pos\PointOfSaleController@payInvoice')->name('sales.invoice.accept_pay');
    });
    Route::group(['prefix' => 'customers'], function () {
        Route::get('create', 'CustomersController@create')->name('customers.create');
        Route::post('create', 'CustomersController@store')->name('customers.save');
        Route::get('search', 'CustomersController@searchCustomer')->name('customers.search');
    });
});
