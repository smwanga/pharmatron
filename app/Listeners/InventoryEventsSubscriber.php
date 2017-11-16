<?php

namespace App\Listeners;

use App\Events\StockAdded;
use App\Events\ProductSold;
use App\Entities\Inventory;
use App\Events\ProductCreated;
use App\Events\ProductUpdated;
use App\Support\Traits\LogsActivity;
use Illuminate\Contracts\Events\Dispatcher;

class InventoryEventsSubscriber
{
    use LogsActivity;

    /**
     * Handle the event.
     *
     * @param StockCreated $event
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(StockAdded::class, [$this, 'stockAdded']);
        $events->listen(ProductSold::class, [$this, 'productSold']);
        $events->listen(ProductCreated::class, [$this, 'productCreated']);
        $events->listen(ProductUpdated::class, [$this, 'productUpdated']);
        $events->listen(SaleDeleted::class, [$this, 'saleDeleted']);
    }

    /**
     * Handle stock added event.
     *
     * @param StockAdded $event
     **/
    public function stockAdded(StockAdded $event)
    {
        $data = [
            'qty' => $event->stock->stock_available,
            'on_stock' => $event->stock->product->available_stock,
            'product_id' => $event->stock->product_id,
            'tr_type' => 'add_stock',
        ];
        $params = [
            'product' => $event->stock->product->item_name,
            'qty' => $data['on_stock'],
            'ref' => $event->stock->ref_number,
        ];
        $data['comment'] = trans('messages.loging.add_stock', $params);
        $this->updateInventory($data);
        $log = [
            'type' => 'add_stock',
            'action' => 'primary',
            'icon' => 'fa fa-share-square-o',
            'details' => trans('messages.loging.add_stock', $params),
        ];
        $this->logActivity(auth()->user(), $log);
    }

    /**
     * Handle for product sold event.
     *
     * @param ProductSold $event
     **/
    public function productSold(ProductSold $event)
    {
        $invoice = $event->saleItem->sale;
        $total = $event->saleItem->unit_cost * $event->saleItem->qty;
        $data = [
            'qty' => $event->saleItem->qty,
            'on_stock' => $event->product->available_stock,
            'product_id' => $event->product->id,
            'comment' => "Sold {$event->saleItem->qty} units of {$event->product->item_name} to {$invoice->customer_name}. Total cost: {$total}",
            'tr_type' => 'product_sold',
        ];
        $this->updateInventory($data);
    }

    /**
     * Handle for product sold event.
     *
     * @param ProductSold $event
     **/
    public function productCreated(ProductCreated $event)
    {
        $data = [
            'qty' => 0,
            'on_stock' => 0,
            'product_id' => $event->product->id,
            'comment' => trans('messages.add_product'),
            'tr_type' => 'add_product',
        ];
        $this->updateInventory($data);

        $params = [
            'product' => $event->product->item_name,
        ];
        $log = [
            'type' => 'add_product',
            'action' => 'success',
            'icon' => 'fa fa-medkit',
            'details' => trans('messages.loging.add_product', $params),
        ];
        $this->logActivity(auth()->user(), $log);
    }

    /**
     * Handle for product updated event.
     *
     * @param ProductUpdated $event
     **/
    public function productUpdated(ProductUpdated $event)
    {
        $params = [
            'product' => $event->product->item_name,
        ];
        $log = [
            'type' => 'edit_product',
            'action' => 'info',
            'icon' => 'fa fa-medkit',
            'details' => trans('messages.loging.edit_product', $params),
        ];
        $this->logActivity(auth()->user(), $log);
    }

    /**
     * Handle for product updated event.
     *
     * @param ProductUpdated $event
     **/
    public function saleDeleted(SaleDeleted $event)
    {
        $sale = $event->sale;
        $log = [
            'type' => 'delete_sale',
            'action' => 'danger',
            'icon' => 'fa fa-credit-card',
            'details' => "Daleted a sale record worth Ksh {$sale->total}",
        ];
        $this->logActivity(auth()->user(), $log);
    }

    /**
     * Update product inventory.
     *
     * @author
     **/
    protected function updateInventory(array $data)
    {
        $data = array_merge([
            'created_by' => auth()->user()->id,
        ], $data);
        Inventory::create($data);
    }
}
