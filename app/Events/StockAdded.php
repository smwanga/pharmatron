<?php

namespace App\Events;

use App\Entities\Stock;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class StockAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Sock eloquent model.
     *
     * @var Stock
     **/
    protected $stock;

    /**
     * Create a new event instance.
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }
}
