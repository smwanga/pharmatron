<?php

namespace App\Http\Controllers\Suppliers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Contracts\Repositories\SupplierRepository as Repository;

class SuppliersController extends Controller
{
    /**
     * Supplier repository.
     *
     * @var Repository
     **/
    protected $repository;

    /**
     * Create a new controller object.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show form for creating a supplier.
     *
     * @return Illuminate\View\Factory
     **/
    public function create()
    {
        $data = [
            'forms' => true,
            'pagetitle' => 'Add Supplier',
            'titles' => [(object)
                [
                'title' => 'Supplier Details',
                'icon' => 'fa fa-briefcase',
                ],
            ],
            'wizard' => (object) [
                'form' => (object) [
                    'action' => route('suppliers.save'),
                    'method' => 'post',
                ],
            ],
        ];

        return view('suppliers.add-supplier', $data);
    }

    /**
     * Save the user submited input to database.
     *
     * @param SupplierRequest $request
     *
     * @return Illuminate\Http\Response
     **/
    public function store(SupplierRequest $request)
    {
        $supplier = $this->repository->create($request->input());

        return with_info();
    }
}
