<?php

namespace App\Http\Controllers\Stock;

use Event;
use App\Entities\Product;
use App\Entities\Category;
use Illuminate\Http\Request;
use App\Events\ProductUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Transformers\ProductsTransformer;
use App\Contracts\Repositories\ProductRepository as Repository;

class ProductsController extends Controller
{
    /**
     * Product repository.
     *
     * @var Repository
     **/
    protected $repository;

    /**
     * Create a new controller object.
     *
     * @param Repository $repository
     */

    /**
     * View data.
     *
     * @var array
     **/
    protected $data = [];

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function index()
    {
        $products = $this->repository->getModel()->where(function ($query) {
            return $query->when($q = request('query'), function ($query) use ($q) {
                return $query->where(function ($query) use ($q) {
                    return $query->where('item_name', 'like', "%{$q}%")
                                ->orWhere('generic_name', 'like', "%{$q}%")
                                ->orWhere('barcode', 'like', "%{$q}%");
                });
            });
        })->orderBy('item_name', 'ASC')->paginate(16);
        $this->data['pagetitle'] = trans('main.products');
        $this->data['products'] = $products;
        $this->data['datatables'] = true;
        $this->data['forms'] = true;

        return view('stock.product-listing', $this->data);
    }

    /**
     * Set default page data.
     *
     * @param array $param
     **/
    protected function setPageData($params)
    {
        $this->data = [
            'categories' => $this->getCategory('formulation'),
            'dispense_unit' => $this->getCategory('dispense_unit'),
            'forms' => true,
            'pagetitle' => $params['title'],
            'titles' => [(object)
                [
                'title' => trans('titles.product_information'),
                'icon' => 'fa fa-home',
                ],
            ],
            'wizard' => (object) [
                'form' => (object) [
                    'action' => $params['action'],
                    'method' => $params['method'],
                ],
            ],
        ];
    }

    /**
     * Search for an item on the point of sale.
     *
     * @param Request $request
     **/
    public function searchProduct(Request $request)
    {
        return $this->repository->all(function ($query) use ($request) {
            return $query->where('barcode', 'like', '%'.$request->get('query').'%')->orWhere('item_name', 'like', '%'.$request->get('query').'%');
        })->map(function ($product) {
            return ['value' => $product->item_name.'[ '.optional($product->category)->category.']', 'data' => $product];
        })->pipe(function ($result) use ($request) {
            return [
                'query' => $request->get('query'),
                'suggestions' => $result,
            ];
        });
    }

    /**
     * Display form for creating a new product.
     *
     * @return Illuminate\View\Factory
     **/
    public function create()
    {
        $params = [
            'method' => 'post',
            'action' => route('products.save'),
            'title' => trans('main.create_product'),
        ];
        $this->setPageData($params);

        return view('stock.add-product', $this->data);
    }

    /**
     * Display form for creating a new product.
     *
     * @return Illuminate\View\Factory
     **/
    public function edit(Product $product)
    {
        $params = [
            'method' => 'patch',
            'action' => route('products.update', $product->id),
            'title' => trans('main.edit_product'),
        ];
        $this->setPageData($params);
        $this->data['product'] = $product;

        return view('stock.edit-product', $this->data);
    }

    /**
     * Get categories by type.
     *
     * @param string $category
     **/
    protected function getCategory($category)
    {
        return Category::whereGroup($category)->orderBy('category', 'ASC')->get();
    }

    /**
     * Save the product in the datastore.
     *
     * @param ProductRequest $request
     *
     * @return \Illuminate\Http\Response
     **/
    public function save(ProductRequest $request)
    {
        $product = $this->repository->create($request->all());
        if ($request->wantsJson()) {
            return ['status' => 'success', 'message' => 'A new product '.$product->item_name.' has been created', 'product' => $product];
        }

        return redirect_with_info(route('stock.create', $product->id));
    }

    /**
     * Show view for displaying product information.
     *
     * @return \Illuminate\View\Factory
     **/
    public function show(Product $product)
    {
        $this->data['pagetitle'] = $product->generic_name;
        $this->data['product'] = $product;
        $this->data['movement'] = $product->stockMovement()->orderBy('created_at', 'DESC')->paginate(10);

        return view('stock.product', $this->data);
    }

    /**
     * Show view for displaying product information.
     *
     * @return \Illuminate\View\Factory
     **/
    public function showBarcodes(Product $product)
    {
        $this->data['pagetitle'] = 'Barcodes '.$product->generic_name;
        $this->data['product'] = $product;

        return view('stock.barcodes', $this->data);
    }

    /**
     * Get json data for datatables API.
     *
     * @return array Table rows
     **/
    public function getData()
    {
        return DataTables::eloquent($this->repository->getModel()::query())
         ->setTransformer(new ProductsTransformer())
         ->make();
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function update(Request $request, Product $product)
    {
        $rules = [
            'generic_name' => 'required',
            'stock_code' => 'required|unique:products,stock_code,'.$product->id,
            'barcode' => 'nullable|numeric|unique:products,barcode,'.$product->id,
            'unit' => 'required',
            'alert_level' => 'nullable|numeric|min:0',
            'description' => 'required|string',
        ];
        $dirty = clone $product;
        $this->validate($request, $rules);
        $product->update($request->input());

        Event::fire(new ProductUpdated($dirty, $product));

        return redirect_with_info(route('products.index'));
    }

    public function delete(Product $product)
    {
        if ($product->delete()) {
            return ['status' => 'success', 'message' => 'Product was successfully deleted'];
        }

        return ['status' => 'error', 'message' => 'an error was encountered whie deleting product'];
    }
}
