<?php

namespace App\Repositories;

use Event;
use App\Entities\Address;
use App\Entities\Invoice;
use App\Events\InvoiceCreated;
use App\Contracts\Repositories\InvoiceRepository as Repository;

class InvoiceRepository extends BaseRepository implements Repository
{
    /**
     * Address database model.
     *
     * @var Address
     **/
    protected $address;

    /**
     * Instantiate a new Repository object.
     *
     * @param Invoice $invoice
     *
     * @author Leitato Albert <wizqydy@gmail.com>
     **/
    public function __construct(Invoice $invoice, Address $address)
    {
        $this->model = $invoice;
        $this->address = $address;
    }

    /**
     * Create an invoice in the database.
     *
     * @param array $attributes Fields to be populated
     **/
    public function create(array $attributes)
    {
        $address = $this->address->create($attributes);
        $invoice = $address->invoice()->create($attributes);
        Event::fire(new InvoiceCreated($invoice));

        return $invoice;
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
