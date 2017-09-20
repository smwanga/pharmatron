<?php

namespace App\Events;

use App\Entities\Product;
use App\Entities\SaleItem;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProductSold
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;

    /**
     * Sale Item .
     *
     * @var int
     */
    public $saleItem;

    /**
     * Create a new event instance.
     */
    public function __construct(Product $product, SaleItem $item)
    {
        $this->product = $product;
        $this->saleItem = $item;
    }
}
