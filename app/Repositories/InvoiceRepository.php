<?php

namespace App\Repositories;

use Event;
use App\Entities\Invoice;
use App\Events\InvoiceCreated;
use App\Contracts\Repositories\InvoiceRepository as Repository;

class InvoiceRepository extends BaseRepository implements Repository
{
    /**
     * Instantiate a new Repository object.
     *
     * @param Invoice $invoice
     *
     * @author Leitato Albert <wizqydy@gmail.com>
     **/
    public function __construct(Invoice $invoice)
    {
        $this->model = $invoice;
    }

    /**
     * Create an invoice in the database.
     *
     * @param array $attributes Fields to be populated
     **/
    public function create(array $attributes)
    {
        $invoice = $this->model->create($attributes);
        Event::fire(new InvoiceCreated($invoice));

        return $product;
    }

    /**
     * Get invoices.
     *
     * @return \Illuminate\Database\Collection
     **/
    public function invoices()
    {
        return $this->model->where('type', 'invoice')->get();
    }
}
