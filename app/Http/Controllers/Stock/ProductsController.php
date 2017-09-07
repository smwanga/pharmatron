<?php

namespace App\Http\Controllers\Stock;

use DataTables;
use App\Entities\Product;
use App\Entities\Category;
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
     * Display form for creating a new product.
     *
     * @return Illuminate\View\Factory
     **/
    public function create()
    {
        $this->data = [
            'categories' => $this->getCategory('product'),
            'dispense_unit' => $this->getCategory('dispense_unit'),
            'forms' => true,
            'pagetitle' => trans('main.create_stock'),
            'titles' => [(object)
                [
                'title' => 'Product Information',
                'icon' => 'fa fa-home',
                ],
            ],
            'wizard' => (object) [
                'form' => (object) [
                    'action' => route('products.save'),
                    'method' => 'post',
                ],
            ],
        ];

        return view('stock.add-product', $this->data);
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
     * undocumented function.
     *
     * @author
     **/
    public function show(Product $product)
    {
        $this->data['pagetitle'] = $product->generic_name;
        $this->data['product'] = $product;

        return view('stock.product', $this->data);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function getData()
    {
        return DataTables::eloquent($this->repository->getModel()::query())
         ->setTransformer(new ProductsTransformer())
         ->make();
    }
}
