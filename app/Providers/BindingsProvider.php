<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BindingsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $contract = 'App\\Contracts\\Repositories\\';
        $repository = 'App\\Repositories\\';
        $this->app->bind($contract.'ProductRepository', $repository.'ProductRepository');
        $this->app->bind($contract.'StockRepository', $repository.'StockRepository');
        $this->app->bind($contract.'SupplierRepository', $repository.'SupplierRepository');
        $this->app->bind($contract.'InvoiceRepository', $repository.'InvoiceRepository');
    }
}
