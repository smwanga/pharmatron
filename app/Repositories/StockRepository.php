<?php

namespace App\Repositories;

use Event;
use Closure;
use App\Entities\Stock;
use App\Entities\Invoice;
use App\Events\StockAdded;
use App\Contracts\Repositories\StockRepository as Repository;

class StockRepository extends BaseRepository implements Repository
{
    /**
     * Model attributes.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $attributes;

    /**
     * Http Response.
     *
     * @var \Illuminate\Http\Response
     */
    protected $response;

    /**
     * Instantiate a new Repository object.
     *
     * @param Stock $stock
     *
     * @author Leitato Albert <wizqydy@gmail.com>
     **/
    public function __construct(Stock $stock)
    {
        $this->model = $stock;
    }

    /**
     * Create a stock in the database.
     *
     * @param array $attributes Fields to be populated
     **/
    public function create($product, array $attributes)
    {
        $attributes['product_id'] = $product->id;
        $this->attributes = collect($attributes);
        //Check if the stock being added has an purchase order number
        //If it has update the order with the stock value added
        if ($lpo = $this->attributes->get('lpo_number')) {
            $order = Invoice::where('reference_no', $lpo)->first();
            if (!$order) {
                return with_info("The purchase order with reference number $lpo was nor found", 'error')->withInput();
            }

            return $order->lpoItems->where('product_id', $product->id)
                ->each(function ($item) {
                    $qty = $item->received_qty + $this->attributes->get('qty');
                    if ($item->qty >= $qty) {
                        $this->attributes->push('supplier_id', $item->invoice->supplier->id);
                        $item->update(['received_qty' => $qty]);
                        $this->save($this->attributes->all());

                        return
                        $this->response =
                        $this->attributes->has('order_id') ?
                        redirect_with_info(route('purchase_order.show', $item->invoice->id)) :
                        redirect_with_info(route('stock.add'));
                    }

                    $this->response = with_info('The quantity exceeds that spicified in the purchase order', 'error', 'Error on request')->withInput();
                })
                ->pipe(function ($orderItems) {
                    if (!$orderItems->count()) {
                        $this->response = with_info('The product was not found in the purchase order please make sure it was added to the order', 'error', 'Error on request')->withInput();
                    }

                    return $this->response;
                });
        }
        $this->save($this->attributes->all());

        return redirect_with_info(route('stock.add'));
    }

    /**
     * Persist record to the database.
     *
     * @return Stock
     **/
    protected function save(array $attributes)
    {
        $stock = $this->model->create($attributes);
        event(new StockAdded($stock));

        return $stock;
    }

    /**
     * Get the the total stock value.
     *
     * @return float
     **/
    public function getStockValue()
    {
        return $this->model->available()->get()->map(function ($stock) {
            return $stock->selling_price * $stock->stock_available;
        })->sum();
    }

    /**
     * Get paginated results.
     *
     * @return Illuminate\Database\Collection
     **/
    public function paginate(Closure $callback = null)
    {
        return $this->runCallback($callback)->paginate(30);
    }

    public function deepSearch($q, $range, $column = 'stocks.created_at')
    {
        return $this->model->select(
            'stocks.*',
            'suppliers.supplier_name',
            'products.*',
            'stocks.id as id'
        )->join(
            'suppliers',
            'stocks.supplier_id',
            '=',
            'suppliers.id'
        )
        ->join(
            'products',
            'products.id',
            '=',
            'stocks.product_id'
        )
        ->when($q, function ($query) use ($q) {
            return $query->where(function ($query) use ($q) {
                return $query->orWhere('stocks.ref_number', 'like', "%{$q}%")
                    ->orWhere('suppliers.supplier_name', 'like', "%{$q}%")
                    ->orWhere('products.item_name', 'like', "%{$q}%")
                    ->orWhere('products.generic_name', 'like', "%{$q}%")
                    ->orWhere('products.stock_code', 'like', "%{$q}%")
                    ->orWhere('products.barcode', 'like', "%{$q}%")
                    ->orWhere('stocks.lpo_number', 'like', "%{$q}%");
            });
        })->when($range, function ($query) use ($column) {
            extract(date_range(request()));

            return $query->whereBetween($column, [$from, $to]);
        })->orderBy($column, 'DESC');
    }

    public function expired()
    {
        return $this->model->expired();
    }
}
