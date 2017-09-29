<?php

namespace App\Repositories;

use Event;
use App\Entities\Supplier;
use App\Events\CompanyCreated;
use App\Contracts\Repositories\SupplierRepository as Repository;

class SupplierRepository extends BaseRepository implements Repository
{
    /**
     * Instantiate a new Repository object.
     *
     * @param Supplier $supplier
     *
     * @author Leitato Albert <wizqydy@gmail.com>
     **/
    public function __construct(Supplier $supplier)
    {
        $this->model = $supplier;
    }

    /**
     * Create a supplier in the database.
     *
     * @param array $attributes Fields to be populated
     **/
    public function create(array $attributes)
    {
        $supplier = $this->model->create($attributes);
        Event::fire(new CompanyCreated($supplier));

        return $supplier;
    }

    /**
     * Supplier invoices.
     *
     *
     * @author
     **/
    public function invoiceData($supplier)
    {
        return $supplier->invoices()->where('type', 'Invoice')->get()->map(function ($invoice) {
            return ['total' => $invoice->total, 'paid' => $invoice->paid, 'due' => $invoice->due];
        });
    }
}
