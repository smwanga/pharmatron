<?php

namespace App\Http\Controllers\Stock;

use App\Entities\Product;
use App\Http\Requests\StockRequest;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\StockRepository;
use App\Contracts\Repositories\SupplierRepository;

class StockController extends Controller
{
    /**
     * Stock repository instance.
     *
     * @var StockRepository
     **/
    protected $repository;

    /**
     * Suppliers repository instance.
     *
     * @var SupplierRepository
     **/
    protected $suppliers;

    /**
     * Create a new controller object.
     *
     * @param SupplierRepository $suppliers
     * @param StockRepository    $repository
     */
    public function __construct(SupplierRepository $suppliers, StockRepository $repository)
    {
        $this->suppliers = $suppliers;
        $this->repository = $repository;
    }

    /**
     * undocumented function.
     *
     * @return Illuminate\Http\Response
     **/
    public function index()
    {
        $stock = $this->repository->paginate();
        $stock_value = $this->repository->getStockValue();

        return view('stock.stock-listing', compact('stock', 'stock_value'));
    }

    /**
     * Show page for adding products stock.
     *
     * @param Product $product
     *
     * @return Illuminate\View\Factory
     **/
    public function create(Product $product)
    {
        $data = [
            'forms' => true,
            'pagetitle' => $product->generic_name,
            'titles' => [(object)
                [
                'title' => 'Product Information',
                'icon' => 'fa fa-home',
                ],
            ],
            'wizard' => (object) [
                'form' => (object) [
                    'action' => route('stock.save', $product->id),
                    'method' => 'post',
                ],
            ],
            'suppliers' => $this->suppliers->all(),
            'product' => $product,
        ];

        return view('stock.add-stock', $data);
    }

    /**
     * Handle the storing of the ne stock to the database.
     *
     * @param StockRequest $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     **/
    public function store(Product $product, StockRequest $request)
    {
        $this->repository->create($product, $request->input());

        return with_info();
    }
}
