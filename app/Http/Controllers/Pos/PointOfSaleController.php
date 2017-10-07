<?php

namespace App\Http\Controllers\Pos;

use DB;
use Event;
use Carbon\Carbon;
use App\Entities\Sale;
use App\Entities\SaleItem;
use App\Events\ProductSold;
use App\Events\SaleDeleted;
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
    public function index(Request $request)
    {
        if ($request->has('query') || $request->has('range')) {
            $q = $request->get('query');
            $sales = Sale::when($q, function ($query) use ($q) {
                return $query->where('customer_name', 'like', "%{$q}%")->orWhere('ref_number', 'like', "%{$q}%");
            })
            ->when($request->get('range'), function ($query) use ($request) {
                extract(date_range($request));

                return $query->whereBetween('created_at', [$from, $to]);
            });
        } else {
            $sales = Sale::orderBy('created_at', 'DESC');
        }
        $forms = true;
        if ($request->has('print')) {
            return view('reports.sales-report', ['sales' => $sales->get(), 'title' => 'Sales Report']);
        }
        $sales = $sales->paginate(20);

        return view('pos.sales', compact('sales', 'forms'));
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function create(Sale $sale)
    {
        $data = [
            'forms' => true,
            'pagetitle' => trans('main.create_sale'),
            'items' => [],
        ];
        if ($sale->type !== null) {
            if ($sale->type !== 'draft') {
                if (!\Bouncer::allows('can_update_dispensed_sale') || $sale->paid > 0) {
                    return with_info('Editing of this prescription is not permited', 'error', 'Sorry!!');
                }
            }
            $data['items'] = $sale->items;
        }
        $data['sale'] = $sale;

        return view('pos.create-sale', $data);
    }

    /**
     * Search for an item on the point of sale.
     *
     * @param Request $request
     **/
    public function searchItem(Request $request)
    {
        $result = $this->products->all(function ($query) use ($request) {
            return $query->where('barcode', 'like', '%'.$request->get('query').'%')->orWhere('item_name', 'like', '%'.$request->get('query').'%');
        })->map(function ($product) {
            if ($product->available_stock > 0) {
                return ['value' => $product->item_name.'[ '.$product->barcode.']', 'data' => $product->id, 'product' => $product->item_name];
            }
        });

        $q = [
            'suggestions' => [],
            'query' => $request->get('query'),
        ];
        foreach ($result->all() as $key => $value) {
            if ($value !== null) {
                $q['suggestions'][] = $value;
            }
        }

        return $q;
    }

    /**
     * Add an item to the prescription.
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

            return response(['status' => 'success', 'sale' => $sale, 'data' => $data]);
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
    public function delete(Sale $sale)
    {
        $clone = clone $sale;
        if ($sale->delete()) {
            Event::fire(new SaleDeleted($clone));

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
            if (!$sale->dispensed_at) {
                $sale->items->each(function ($item) {
                    $item->product->sell($item->qty);
                    Event::fire(new ProductSold($item->product, $item));
                });
                $sale->dispensed_at = Carbon::now();
                $sale->save();
            }
            if ($request->get('cash') >= $sale->due && $sale->due > 0) {
                $sale->payments()->create(['amount' => $sale->due, 'person_name' => $sale->customer_name, 'mode' => 'Cash']);
            }

            return redirect_with_info(route('sales.invoice', $sale->id));
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
    public function addAsCredit(Sale $sale)
    {
        if ($credit = request()->get('credit_sale')) {
            $company = optional($sale->customer)->company;
            if (!$company) {
                return response(['status' => 'error', 'message' => 'There is no company to credit this invoice. check if the selected customer belongs to a company', 'title' => 'No Company selected']);
            }
            $id = $credit === 'credit' ? $company->id : null;
            $sale->company_id = $id;
            $sale->save();
            if ($id) {
                return response(['status' => 'success', 'message' => "{$company->company_name} has been credited for this sale", 'title' => 'Sale credited']);
            }

            return response(['status' => 'info', 'message' => "The sale has been detached from {$company->company_name} credit records", 'title' => 'Credit detached']);
        }
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
        if (request()->has('print')) {
            return app('snappy.pdf.wrapper')->loadView('pos.pdf-invoice', $data)->inline($sale->ref_number.'-sale-invoice.pdf');
        }
        if (request()->get('receipt')) {
            return view('pos.sale-receipt', $data);
        }

        return view('pos.sale-invoice', $data);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function showInvoiceLabels(Sale $sale)
    {
        $data = ['pagetitle' => 'Labels ', 'forms' => true, 'sale' => $sale];
        if ($print = request()->get('print')) {
            $pdf = \PDF::loadView('pos.pdf-labels', $data);

            return $print == 'download' ? $pdf->download() : $pdf->inline();
        }

        return view('pos.labels', $data);
    }
}
