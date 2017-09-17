<?php

namespace App\Repositories;

use Event;
use Closure;
use App\Entities\Stock;
use App\Events\StockAdded;
use App\Contracts\Repositories\StockRepository as Repository;

class StockRepository extends BaseRepository implements Repository
{
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
        $stock = $this->model->create($attributes);
        Event::fire(new StockAdded($stock));

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
}
