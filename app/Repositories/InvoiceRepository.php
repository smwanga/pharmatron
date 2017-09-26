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

    /**
     * Get invoices.
     *
     * @return \Illuminate\Database\Collection
     **/
    public function orders()
    {
        return $this->model->select(
            'invoices.*'
        )->where('invoices.type', 'LPO')
        ->join(
            'suppliers',
            'invoices.supplier_id',
            '=',
            'suppliers.id'
        )
        ->join(
            'addresses',
            'addresses.id',
            '=',
            'invoices.address_id'
        );
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function deepSearch($range, $param)
    {
        return $this->orders()->when($param, function ($query) use ($param) {
            return $query->where('invoices.reference_no', 'like', "%{$param}%")
                        ->orWhere('suppliers.supplier_name', 'like', "%{$param}%")
                        ->orWhere('invoices.status', 'like', "%{$param}%");
        })->when($range, function ($query) {
            extract(date_range(request()));

            return $query->whereBetween('invoices.delivery_date', [$from, $to]);
        });
    }
}
