<?php

namespace App\Events;

use App\Entities\Product;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProductUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * Model beofre update.
     *
     * @var Product
     */
    public $dirty;
    /**
     * Model after update.
     *
     * @var Product
     */
    public $product;

    /**
     * Create a new event instance.
     */
    public function __construct(Product $dirty, Product $product)
    {
        $this->dirty = $dirty;
        $this->product = $product;
    }
}
