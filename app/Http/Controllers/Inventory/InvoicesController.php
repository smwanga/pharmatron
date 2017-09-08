<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\InvoiceRepository;

class InvoicesController extends Controller
{
    /**
     * Ivoice repository.
     *
     * @var string
     **/
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @param InvoiceRepository $repository
     **/
    public function __construct(InvoiceRepository $repository)
    {
        $this->repository = $repository;
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
}
