<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\InvoiceRepository;
use App\Contracts\Repositories\SupplierRepository;

class InvoicesController extends Controller
{
    /**
     * Ivoices repository.
     *
     * @var string
     **/
    protected $repository;
    /**
     * Suppliers repository.
     *
     * @var SupplierRepository
     **/
    protected $suppliers;

    /**
     * Create a new controller instance.
     *
     * @param InvoiceRepository $repository
     **/
    public function __construct(InvoiceRepository $repository, SupplierRepository $suppliers)
    {
        $this->repository = $repository;
        $this->suppliers = $suppliers;
    }

    /**
     * Show an invoice listing.
     *
     * @author
     **/
    public function index()
    {
        $data = [
            'invoices' => $this->repository->invoices(),
        ];
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function search(Request $request)
    {
        return $this->repository->all(function ($query) use ($request) {
            return $query->where('reference_no', 'like', '%'.$request->get('query')).'%';
        });
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function createPurchaseOrder()
    {
        $data = [
            'suppliers' => $this->suppliers->all(),
            'forms' => true,
        ];

        return view('inventory.create-purchase-order', $data);
    }
}
