<?php

namespace App\Events;

use App\Entities\Supplier;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SupplierCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Supplier Eloquent model instance.
     *
     * @var Supplier
     **/
    public $supplier;

    /**
     * Create a new event instance.
     */
    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }
}
