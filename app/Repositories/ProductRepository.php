<?php

namespace App\Repositories;

use Event;
use App\Entities\Product;
use App\Entities\Category;
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
        if (array_key_exists('dispensing_unit', $attributes)) {
            $category = Category::where('category', $attributes['dispensing_unit'])->first();
            //To be on the safe side we wrap this on an optional function
            //At times the category will be missing
            $attributes['unit'] = optional($category)->id;
        }
        $product = $this->model->create($attributes);
        Event::fire(new ProductCreated($product));

        return $product;
    }
}
