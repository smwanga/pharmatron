<?php

namespace App\Http\Controllers\Stock;

use DataTables;
use App\Entities\Product;
use App\Entities\Category;
use Illuminate\Http\Request;
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
        $this->data['pagetitle'] = trans('main.products');
        $this->data['products'] = $this->repository->all();
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
            'categories' => $this->getCategory('product'),
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
            'category_id' => 'required',
            'unit' => 'required',
            'alert_level' => 'nullable|numeric|min:0',
            'description' => 'required|string',
        ];
        $this->validate($request, $rules);
        $product->update($request->input());

        return redirect_with_info(route('products.index'));
    }
}
