<?php

namespace App\Repositories;

use Event;
use App\Entities\Product;
use App\Events\ProductCreated;
use App\Contracts\Repositories\ProductRepository as Repository;

class ProductRepository extends BaseRepository implements Repository
{
    /**
     * Instantiate a new Repository object.
     *
     * @param Product $product
     *
     * @author Leitato Albert <wizqydy@gmail.com>
     **/
    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    /**
     * Create a product in the database.
     *
     * @param array $attributes Fields to be populated
     **/
    public function create(array $attributes)
    {
        $product = $this->model->create($attributes);
        Event::fire(new ProductCreated($product));

        return $product;
    }
}
