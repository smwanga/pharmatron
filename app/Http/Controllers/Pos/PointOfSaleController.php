<?php

namespace App\Http\Controllers\Pos;

use DB;
use App\Entities\Sale;
use App\Entities\SaleItem;
use App\Events\ProductSold;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\Repositories\ProductRepository as Repository;

class PointOfSaleController extends Controller
{
    /**
     * undocumented function.
     *
     * @author
     **/
    public function __construct(Repository $repository)
    {
        $this->products = $repository;
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function index()
    {
        $sales = Sale::orderBy('created_at', 'DESC')->paginate(30);
        $forms = true;

        return view('pos.sales', compact('sales', 'forms'));
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function create(Sale $sale = null)
    {
        $data = [
            'forms' => true,
            'pagetitle' => trans('main.create_sale'),
            'items' => [],
        ];
        if ($sale !== null) {
            $data['sale'] = $sale;
            $data['items'] = $sale->items;
        }

        return view('pos.create-sale', $data);
    }

    /**
     * Search for an item on the point of sale.
     *
     * @param Request $request
     **/
    public function searchItem(Request $request)
    {
        return $this->products->all(function ($query) use ($request) {
            return $query->where('barcode', 'like', '%'.$request->get('query').'%')->orWhere('generic_name', 'like', '%'.$request->get('query').'%');
        })->map(function ($product) {
            if ($product->available_stock > 0) {
                return ['value' => $product->generic_name.'[ '.$product->barcode.']', 'data' => $product];
            }
        })->pipe(function ($result) use ($request) {
            return [
                'query' => $request->get('query'),
                'suggestions' => $result,
            ];
        });
    }

    /**
     * undocumented function.
     *
     * @param Illuminate\Http\Request $request
     **/
    public function addItem(Request $request, $id = null)
    {
        $item = $this->products->findBy('id', $request->get('product'));
        if ($item->available_stock > 0) {
            $stock = $item->for_sale;
            $data = [
                'qty' => 1,
                'unit_cost' => $stock->selling_price,
                'instructions' => $item->instructions ?: '',
                'product_id' => $item->id,
            ];
            $default = ['discount' => 0, 'tax' => 0, 'type' => 'draft'];
            $sale = Sale::firstOrCreate(['id' => $id], $default);
            $sale->items()->updateOrCreate(['product_id' => $item->id], $data);

            return $sale;
        }

        return response(['status' => 'error', 'message' => 'An error was encountered while performing the request', 'data' => []], 500);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function updateItem(Request $request, SaleItem $item)
    {
        $this->validate($request, ['qty' => 'numeric|min:1', 'unit_cost' => 'numeric|min:1', 'instructions' => 'string|max:1000']);
        $item->update($request->input());

        return $item;
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function deleteItem(Request $request, SaleItem $item)
    {
        if ($item->delete()) {
            return response(['status' => 'success', 'message' => 'Item was deleted']);
        }

        return response(['status' => 'error', 'message' => 'Failed Bad Request'], 405);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function payInvoice(Sale $sale, Request $request)
    {
        return DB::transaction(function () use ($sale, $request) {
            if ($request->get('cash') >= $sale->due && $sale->due > 0) {
                $sale->items->each(function ($item) {
                    $item->product->sell($item->qty);
                    event(new ProductSold($item->product, $item));
                });
                $sale->payments()->create(['amount' => $sale->due, 'person_name' => $sale->customer_name, 'mode' => 'Cash']);

                return redirect_with_info(route('sales.invoice', $sale->id));
            }

            return with_info('Error processing payment', 'Error', 'error');
        });
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function showPayInvoice(Sale $sale)
    {
        return view('pos.modals.accept-payment', compact('sale'));
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function update(Request $request, Sale $sale)
    {
        $this->validate($request, ['tax' => 'numeric|min:0|max:100', 'discount' => 'numeric|min:0|max:100', 'customer_name' => 'nullable|string|max:255']);
        $sale->update($request->input());

        return response(['status' => 'success', 'message' => 'Item was successfully updated']);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function getCustomer()
    {
        // Get customer details for consumption by Autocomplete
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function showInvoice(Sale $sale)
    {
        $ribbon = sale_ribbon($sale->due, $sale->total);
        $data = ['pagetitle' => 'Sales invoice '.$sale->ref_number, 'forms' => true, 'sale' => $sale, 'ribbon' => $ribbon];

        return view('pos.sale-invoice', $data);
    }
}
