<?php

Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('home'));
});
Breadcrumbs::register('products.index', function ($breadcrumbs) {
    $breadcrumbs->push('Products', route('products.index'));
});
Breadcrumbs::register('products.create', function ($breadcrumbs) {
    $breadcrumbs->parent('products.index');
    $breadcrumbs->push('Create Product', route('products.create'));
});
Breadcrumbs::register('stock.create', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('products.index');
    $breadcrumbs->push('Add Product Stock', route('stock.create', $product->id));
});
Breadcrumbs::register('suppliers.index', function ($breadcrumbs) {
    $breadcrumbs->push('Suppliers', route('suppliers.index'));
});
Breadcrumbs::register('suppliers.create', function ($breadcrumbs) {
    $breadcrumbs->parent('suppliers.index');
    $breadcrumbs->push('Create Supplier', route('suppliers.create'));
});
Breadcrumbs::register('categories.index', function ($breadcrumbs) {
    $breadcrumbs->push('Categories', route('categories.index'));
});
Breadcrumbs::register('products.show', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('products.index');
    $breadcrumbs->push($product->stock_code, route('products.show', $product->id));
});
Breadcrumbs::register('users.index', function ($breadcrumbs) {
    $breadcrumbs->push('Users', route('users.index'));
});
Breadcrumbs::register('users.create', function ($breadcrumbs) {
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push('Create a new User', route('users.create'));
});

Breadcrumbs::register('sales.index', function ($breadcrumbs) {
    $breadcrumbs->push('Sales', route('sales.index'));
});

Breadcrumbs::register('sales.invoice', function ($breadcrumbs, $sale) {
    $breadcrumbs->parent('sales.index');
    $breadcrumbs->push('Sales invoice '.$sale->ref_number, route('sales.invoice', $sale->id));
});
