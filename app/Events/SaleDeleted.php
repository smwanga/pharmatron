<?php

namespace App\Events;

use App\Entities\Sale;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SaleDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The deleted sale model.
     *
     * @var Sale
     **/
    public $sale;

    /**
     * Create a new event instance.
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }
}
