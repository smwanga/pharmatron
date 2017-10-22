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
Route::group(['prefix' => 'ussd'], function () {
    Route::match(['GET', 'POST'], 'demo-app', 'UssdController');
});
Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')
    ->name('home');

    Route::group(['prefix' => 'products', 'namespace' => 'Stock'], function () {
        Route::get('/', 'ProductsController@index')
        ->name('products.index');

        Route::get('/create', 'ProductsController@create')
        ->name('products.create');

        Route::get('{product}/product-details/', 'ProductsController@show')
        ->name('products.show');

        Route::post('/save-product', 'ProductsController@save')
        ->name('products.save');

        Route::get('get-products', 'ProductsController@getData')
        ->name('products.get_data');

        Route::get('edit-product/{product}', 'ProductsController@edit')
        ->name('products.edit');

        Route::get('search-product', 'ProductsController@searchProduct')
        ->name('products.search');

        Route::get('product-barcodes/{product}', 'ProductsController@showBarcodes')
        ->name('products.barcodes.show');

        Route::patch('update-product/{product}', 'ProductsController@update')
        ->name('products.update');

        Route::delete('delete-product/{product}', 'ProductsController@delete')
        ->name('products.delete');

        Route::group(['prefix' => 'stock'], function () {
            Route::get('/', 'StockController@index')
            ->name('stock.index');

            Route::get('add', 'StockController@addStock')
            ->name('stock.add');

            Route::get('show-stock/{stock}', 'StockController@viewStock')
            ->name('stock.show');

            Route::get('edit-stock/{stock}', 'StockController@editStock')
            ->name('stock.edit');

            Route::patch('update-stock/{stock}', 'StockController@updateStock')
            ->name('stock.update');

            Route::get('{product}/add', 'StockController@create')
            ->name('stock.create');

            Route::get('expired', 'StockController@expired')
            ->name('stock.expired');

            Route::get('in-active', 'StockController@archived')
            ->name('stock.inactive');

            Route::get('on-low-stock', 'StockController@lowStock')
            ->name('stock.low_stock');

            Route::get('deactivate/{stock}', 'StockController@deactivateStock')
            ->name('stock.deactivate');

            Route::post('{product}/save-stock', 'StockController@store')
            ->name('stock.save');

            Route::get('{stock}/activate-stock', 'StockController@activateStock')
            ->name('stock.activate');

            Route::delete('{stock}/delete-stock', 'StockController@destroy')
            ->name('stock.delete');
        });
    });

    Route::group(['prefix' => 'suppliers', 'namespace' => 'Suppliers'], function () {
        Route::get('/', 'SuppliersController@index')
        ->name('suppliers.index');

        Route::get('create', 'SuppliersController@create')
        ->name('suppliers.create');

        Route::post('create', 'SuppliersController@store')
        ->name('suppliers.save');

        Route::get('edit-profile/{supplier}', 'SuppliersController@edit')
        ->name('suppliers.edit');

        Route::get('add-contact/{supplier}', 'SuppliersController@addContact')
        ->name('suppliers.contacts.add');

        Route::get('etit-contact/{contact}', 'SuppliersController@editContact')
        ->name('suppliers.contacts.edit');

        Route::post('add-contact/{supplier}', 'SuppliersController@saveContact')
        ->name('suppliers.contacts.save');

        Route::patch('update-contact/{contact}', 'SuppliersController@updateContact')
        ->name('suppliers.contacts.update');

        Route::delete('delete-contact/{contact}', 'SuppliersController@deleteContact')
        ->name('suppliers.contacts.delete');

        Route::get('show-profile/{supplier}', 'SuppliersController@show')
        ->name('suppliers.show');

        Route::get('show-profile/{supplier}/orders', 'SuppliersController@purchaseOrders')
        ->name('suppliers.profile.orders');

        Route::patch('update-profile/{supplier}', 'SuppliersController@update')
        ->name('suppliers.update');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoriesController@index')
        ->name('categories.index');

        Route::get('create', 'CategoriesController@create')
        ->name('categories.create')->middleware('can:manage_stock_categories');

        Route::post('save-category', 'CategoriesController@store')
        ->name('categories.save')->middleware('can:manage_stock_categories');

        Route::get('edit-category/{category}', 'CategoriesController@edit')
        ->name('categories.edit')->middleware('can:manage_stock_categories');

        Route::patch('update-category/{category}', 'CategoriesController@update')
        ->name('categories.update')->middleware('can:manage_stock_categories');
    });

    Route::group(['prefix' => 'settings', 'namespace' => 'Settings'], function () {
        Route::get('/', 'SettingsController@index')
        ->name('settings.index');

        Route::get('email-settings', 'SettingsController@emailSettings')
        ->name('settings.email');

        Route::get('product-settings', 'SettingsController@productSettings')
        ->name('settings.products');

        Route::get('create-config-item', 'SettingsController@createConfigItem')
        ->name('settings.config.create');

        Route::get('access-control/{role?}', 'SettingsController@aclSettings')
        ->name('settings.acl.index')->middleware('can:grant_access');
        Route::patch('access-control/{role}', 'SettingsController@updateAclSettings')
        ->name('settings.acl.update')->middleware('can:grant_access');

        Route::group(['middleware' => 'can:grant_access'], function () {
            Route::resource('abilities', 'AbilityController', ['except' => ['show', 'index']]);
        });

        Route::post('save-config-item', 'SettingsController@saveConfigItem')
        ->name('settings.config.save');

        Route::post('save-config-item', 'SettingsController@saveConfigSettings')
        ->name('settings.config.update');
    });

    Route::group(['prefix' => 'users', 'namespace' => 'Users'], function () {
        Route::get('/', 'UsersController@index')
        ->name('users.index');

        Route::get('create', 'UsersController@create')
        ->name('users.create')->middleware('can:users.manage');

        Route::get('show-profile/{user}', 'UsersController@show')
        ->name('users.show');

        Route::get('change-password/{user}', 'UsersController@changePassword')
        ->name('users.pass_change');

        Route::patch('change-password/{user}', 'UsersController@updatePassword')
        ->name('users.pass_update');

        Route::get('show-profile/{user}/timeline', 'UsersController@showTimeline')
        ->name('users.timeline');

        Route::get('edit-profile/{user}', 'UsersController@edit')
        ->name('users.edit');

        Route::delete('delete-user/{user}', 'UsersController@destroy')
        ->name('users.delete');

        Route::post('save-user', 'UsersController@store')
        ->name('users.save')->middleware('can:users.manage');

        Route::patch('update-user/{user}', 'UsersController@update')
        ->name('users.update')->middleware('can:users.manage');
    });

    Route::group(['prefix' => 'invoices'], function () {
        Route::get('search', 'Inventory\InvoicesController@search')
        ->name('invoices.search');
    });

    Route::group(['prefix' => 'purchase-orders', 'namespace' => 'Inventory'], function () {
        Route::get('/', 'PurchaseOrdersController@index')
        ->name('purchase_order.index');

        Route::get('create', 'PurchaseOrdersController@createPurchaseOrder')
        ->name('purchase_order.create');

        Route::get('/search-orders', 'PurchaseOrdersController@search')
        ->name('purchase_order.search');

        Route::get('{lpo}/add-items', 'PurchaseOrdersController@addItems')
        ->name('purchase_order.add_items');

        Route::post('{lpo}/add-items', 'PurchaseOrdersController@addLPOItem')
        ->name('purchase_order.add_item');

        Route::get('lpo-items.{item}/edit-item', 'PurchaseOrdersController@editLPOItem')
        ->name('purchase_order.edit_item');

        Route::get('show-order/{lpo}', 'PurchaseOrdersController@showLPO')
        ->name('purchase_order.show');

        Route::get('edit-order/{order}', 'PurchaseOrdersController@editPurchaseOrder')
        ->name('purchase_order.edit');

        Route::post('lpo-items.{item}/update-item', 'PurchaseOrdersController@updateLPOItem')
        ->name('purchase_order.update_item');

        Route::delete('lpo-items.{item}/delete-item', 'PurchaseOrdersController@deleteLPOItem')
        ->name('purchase_order.delete_item');

        Route::post('save', 'PurchaseOrdersController@savePurchaseOrder')
        ->name('purchase_order.save');

        Route::post('{order}/save-items', 'PurchaseOrdersController@savePurchaseOrderItems')
        ->name('purchase_order.save.items');

        Route::patch('update-order/{order}', 'PurchaseOrdersController@updatePurchaseOrder')
        ->name('purchase_order.update');

        //Invoice
        Route::get('invoice-order/{order}', 'PurchaseOrdersController@invoicePurchaseOrder')
        ->name('purchase_order.create_invoice');

        Route::get('show-invoice/{order}', 'PurchaseOrdersController@showInvoice')
        ->name('purchase_order.invoice');

        Route::get('add-payment-invoice/{invoice}', 'PurchaseOrdersController@addPayment')
        ->name('purchase_order.invoice.add_payment');

        Route::post('payment-invoice/{invoice}', 'PurchaseOrdersController@payInvoice')
        ->name('purchase_order.invoice.pay');
    });

    Route::group(['prefix' => 'sales', 'namespace' => 'Pos'], function () {
        Route::get('/', 'PointOfSaleController@index')
        ->name('sales');

        Route::get('make-sale/{sale?}', 'PointOfSaleController@create')
        ->name('sales.index')->middleware('can:dispense.medicine');

        Route::get('search', 'PointOfSaleController@searchItem')
        ->name('sales.search');

        Route::delete('delete/{sale}', 'PointOfSaleController@delete')
        ->name('sales.delete')->middleware('can:delete_sales_records');

        Route::post('add-item/{sale?}', 'PointOfSaleController@addItem')
        ->name('sales.item.add')->middleware('can:dispense.medicine');

        Route::post('update-item/{item}', 'PointOfSaleController@updateItem')
        ->name('sales.item.update')->middleware('can:dispense.medicine');

        Route::delete('delete-item/{item}', 'PointOfSaleController@deleteItem')
        ->name('sales.item.delete')->middleware('can:dispense.medicine');

        Route::post('update-sale/{sale}', 'PointOfSaleController@update')
        ->name('sales.update')->middleware('can:dispense.medicine');

        Route::get('sales-invoice/{sale}', 'PointOfSaleController@showInvoice')
        ->name('sales.invoice');

        Route::get('sales-invoice/{sale}/pay', 'PointOfSaleController@showPayInvoice')
        ->name('sales.invoice.pay');
        Route::get('sales-invoice/{sale}/labels', 'PointOfSaleController@showInvoiceLabels')
        ->name('sales.invoice.labels');

        Route::post('sales-invoice/{sale}/pay', 'PointOfSaleController@payInvoice')
        ->name('sales.invoice.accept_pay');

        Route::post('sales-invoice-credit/{sale}', 'PointOfSaleController@addAsCredit')
        ->name('sales.invoice.credit');
    });

    Route::group(['prefix' => 'customers'], function () {
        Route::get('create', 'CustomersController@create')
        ->name('customers.create');

        Route::post('create', 'CustomersController@store')
        ->name('customers.save');

        Route::get('search', 'CustomersController@searchCustomer')
        ->name('customers.search');
    });

    Route::get('pdf-test', function () {
        return app('snappy.pdf.wrapper')->loadView('welcome')->inline('test.pdf');
    });

    Route::group(['prefix' => 'companies'], function () {
        Route::get('/', 'CompaniesController@index')
        ->name('companies.index');

        Route::get('create', 'CompaniesController@create')
        ->name('companies.create');

        Route::post('create', 'CompaniesController@store')
        ->name('companies.save');

        Route::get('{company}/show', 'CompaniesController@show')
        ->name('companies.show');

        Route::get('{company}/edit', 'CompaniesController@edit')
        ->name('companies.edit');

        Route::patch('{company}/update', 'CompaniesController@update')
        ->name('companies.update');

        Route::get('add-person/{company}', 'CompaniesController@addPerson')
        ->name('companies.people.add');

        Route::get('invoices/{company}', 'CompaniesController@showCompanyInvoices')
        ->name('companies.invoice');

        Route::get('etit-person/{person}', 'CompaniesController@editPerson')
        ->name('companies.people.edit');

        Route::post('add-person/{company}', 'CompaniesController@savePerson')
        ->name('companies.people.save');

        Route::patch('update-person/{person}', 'CompaniesController@updatePerson')
        ->name('companies.people.update');

        Route::delete('delete-person/{person}', 'CompaniesController@deletePerson')
        ->name('companies.people.delete');
    });
    Route::group(['prefix' => 'backups'], function () {
        Route::get('/', 'BackupsController@index')
        ->name('backup.list');
        Route::get('download', 'BackupsController@download')
        ->name('backup.download');
        Route::get('delete', 'BackupsController@delete')
        ->name('backup.delete');
        Route::get('create', 'BackupsController@create')
        ->name('backup.create');
    });
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
