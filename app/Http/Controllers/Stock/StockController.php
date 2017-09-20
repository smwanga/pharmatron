<?php

namespace App\Http\Controllers\Stock;

use App\Entities\Stock;
use App\Entities\Product;
use Illuminate\Http\Request;
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
        $forms = true;

        return view('stock.stock-listing', compact('stock', 'stock_value', 'forms'));
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

    /**
     * Show view for displaying an individual stock.
     *
     * @param Stock $stock
     *
     * @return \Illuminate\Http\Response
     **/
    public function viewStock(Stock $stock)
    {
        return view('stock.modals.view-stock', compact('stock'));
    }

    /**
     * Show form for editing stock.
     *
     * @param Stock $stock
     *
     * @return \Illuminate\Http\Response
     **/
    public function editStock(Stock $stock)
    {
        $suppliers = $this->suppliers->all();

        return view('stock.modals.edit-stock', compact('stock', 'suppliers'));
    }

    /**
     * Update Stock records.
     *
     * @param Stock $stock
     *
     * @return \Illuminate\Http\Response
     **/
    public function updateStock(Request $request, Stock $stock)
    {
        $rules = [
            'selling_price' => 'required|numeric|min:0',
            'batch_no' => 'nullable|max:60',
            'expire_at' => 'required|date|after:now',
            'lpo_number' => 'nullable|max:60',
            'description' => 'nullable|string|max:255',
        ];
        $this->validate($request, $rules);
        $stock->update($request->only(array_keys($rules)));
        $response = [
                'status' => 'success',
                'title' => trans('main.stock_updated'),
                'message' => trans('messages.stock_updated', ['ref' => $stock->ref_number]),
            ];
        if ($request->wantsJson()) {
            return response()->json($response);
        }

        return redirect_with_info(route('stock.index'), $response['message'], $response['title']);
    }

    /**
     * undocumented function.
     **/
    public function addStock()
    {
        return view('stock.add-product-stock', ['forms' => true, 'pagetitle' => 'Add Product Stock']);
    }
}
