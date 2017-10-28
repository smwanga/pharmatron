<?php

namespace App\Http\Controllers\Stock;

use Carbon\Carbon;
use App\Entities\Stock;
use App\Entities\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Collection;
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
     * Show view for displaying stock.
     *
     * @return Illuminate\Http\Response
     **/
    public function index(Request $request)
    {
        if ($request->has('query') || $request->has('range')) {
            $q = $request->get('query', false);
            $range = $request->get('range', false);
            $stock = $this->repository->deepSearch($q, $range);
        } else {
            $stock = $this->repository->getModel();
        }
        $data = [
            'stock' => $stock,
            'model' => new Stock(),
            'stock_value' => $this->repository->getStockValue(),
            'forms' => true,
            'option' => trans('main.stock_report'),
        ];
        // Render the result
        return $this->getResponse($data, $request);
    }

    /**
     * Return a proper response based on result.
     *
     * @param Collection $stock
     *
     * @return Illuminate\Http\Response
     **/
    protected function getResponse(array $data, Request $request)
    {
        if ($print = $request->get('print', false)) {
            try {
                $pdf = app('snappy.pdf.wrapper')->loadView('reports.stock-value-report', ['product_stock' => $data['stock']->get(), 'title' => $data['option']])->setOrientation('landscape');

                return $print == 'download' ? $pdf->download('stock-value-report.pdf') : $pdf->inline('stock-value-report.pdf');
            } catch (\Exception $e) {
                return view('reports.stock-value-report', ['product_stock' => $data['stock']->get()]);
            }
        }
        // Paginate the result for a better viewing experience
        $data['stock'] = $data['stock']->paginate(30);

        return view('stock.stock-listing', $data);
    }

    /**
     * Filter expired stock.
     *
     * @return Illuminate\Http\Response
     **/
    public function expired(Request $request)
    {
        if ($request->has('query') || $request->has('range')) {
            $q = $request->get('query', false);
            $range = $request->get('range', false);

            $stock = $this->repository
            ->deepSearch($q, $range)
            ->where(function ($query) {
                return $query->whereDate('stocks.expire_at', '<', Carbon::now())
                    ->where('stocks.stock_available', '>', 0);
            });
        } else {
            $stock = $this->repository->getModel()->expired();
        }

        $data = [
            'stock' => $stock,
            'forms' => true,
            'option' => trans('main.expired_stock'),
        ];

        // Render the result
        return $this->getResponse($data, $request);
    }

    /**
     * Filter expired stock.
     *
     * @return Illuminate\Http\Response
     **/
    public function archived(Request $request)
    {
        if ($request->has('query') || $request->has('range')) {
            $q = $request->get('query', false);
            $range = $request->get('range', false);
            $result = $this->repository
            ->deepSearch($q, $range, 'stocks.archived_at');
        } else {
            $result = $this->repository->getModel();
        }

        $data = [
            'stock' => $result->where(function ($query) {
                return $query->where('stocks.active', false)
                        ->where(function ($query) {
                            return $query->where('stocks.stock_available', '>', 0);
                        });
            }),
            'forms' => true,
            'option' => trans('main.archived_stock'),
        ];

        // Render the result
        return $this->getResponse($data, $request);
    }

    /**
     * Filter expired stock.
     *
     * @return Illuminate\Http\Response
     **/
    public function lowStock(Request $request)
    {
        if ($request->has('query') || $request->has('range')) {
            $q = $request->get('query', false);
            $range = $request->get('range', false);
            $result = $this->repository
            ->deepSearch($q, $range);
        } else {
            $result = $this->repository
                            ->getModel()
                            ->select(
                                'stocks.*',
                                'products.*',
                                'stocks.id as id'
                            )
                            ->join(
                                'products',
                                'products.id',
                                '=',
                                'stocks.product_id'
                            );
        }

        $data = [
            'stock' => $result->where(function ($query) {
                return $query->where('stocks.active', true)
                        ->where(function ($query) {
                            return $query->whereColumn(
                                'stocks.stock_available',
                                '<',
                                'products.alert_level'
                            );
                        });
            }),
            'forms' => true,
            'option' => trans('main.low_stock'),
        ];

        // Render the result
        return $this->getResponse($data, $request);
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
            'item' => optional(null),
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
        $response = $this->repository->create($product, $request->input());
        $data = $request->only('supplier_id', 'ref_number', 'lpo_number', 'save_lpo_number');
        if ($request->has('save_lpo_number')) {
            session($data);
        } else {
            foreach ($data as $key => $value) {
                if (session()->has($key)) {
                    session()->forget($key);
                }
            }
        }

        return $response;
    }

    /**
     * Disalble stock from being sold.
     *
     * @param Stock $stock [description]
     *
     * @return Illuminate\Http\Response
     */
    public function deactivateStock(Stock $stock)
    {
        $stock->active = false;
        $stock->archived_at = Carbon::now();
        $stock->save();

        return with_info();
    }

    /**
     * Activate stock from being sold.
     *
     * @param Stock $stock [description]
     *
     * @return Illuminate\Http\Response
     */
    public function activateStock(Stock $stock)
    {
        if ($stock->is_inactive) {
            $stock->active = 1;
            $stock->archived_at = null;
            $stock->save();

            return with_info();
        }

        return with_info('Cannot add item back to stock', 'error');
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
     * Remove stock from the records.
     *
     * @param Stock $stock
     *
     * @return \Illuminate\Http\Response
     **/
    public function destroy(Stock $stock)
    {
        if ($stock->delete()) {
            return ['status' => 'success', 'message' => 'Stock deleted'];
        }

        return response(['status' => 'error', 'message' => 'Error while deleting product stock'], 500);
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
     * Show view for searching for a product.
     *
     * @return Illuminate\Http\Response
     **/
    public function addStock()
    {
        return view('stock.add-product-stock', ['forms' => true, 'pagetitle' => 'Add Product Stock']);
    }
}
