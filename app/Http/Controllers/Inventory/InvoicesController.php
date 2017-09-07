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
        $invoices = collect([['text' => 'DFH47KFJGGJ [Dawa Bora Suppliers]', 'id' => 1, 'amount' => 1000], ['text' => 'FHR54VFG76', 'id' => 2, 'amount' => 1400], ['text' => 'RTG46GR45', 'id' => 3, 'amount' => 2000]]);

        return $invoices->all();
    }
}
