<?php

namespace App\Http\Controllers\Inventory;

use App\Entities\Stock;
use App\Entities\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests\LPORequest;
use App\Entities\PurchaseOrderItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\LPOItemRequest;
use App\Contracts\Repositories\InvoiceRepository;
use App\Contracts\Repositories\SupplierRepository;

class PurchaseOrdersController extends Controller
{
    /**
     * Ivoices repository.
     *
     * @var string
     **/
    protected $repository;
    /**
     * Suppliers repository.
     *
     * @var SupplierRepository
     **/
    protected $suppliers;

    /**
     * Create a new controller instance.
     *
     * @param InvoiceRepository $repository
     **/
    public function __construct(InvoiceRepository $repository, SupplierRepository $suppliers)
    {
        $this->repository = $repository;
        $this->suppliers = $suppliers;
    }

    /**
     * Show an invoice listing.
     *
     * @author
     **/
    public function index(Request $request)
    {
        if ($request->has('query') || $request->has('range')) {
            $orders = $this->repository->deepSearch($request->get('range', false), $request->get('query'));
        } else {
            $orders = $this->repository->orders();
        }
        $data = [
            'forms' => 'true',
            'orders' => $orders,
        ];

        return $this->getResponse($data, $request);
    }

    /**
     * Search a purchase order by refernce number.
     *
     * @param Request $request
     *
     * @return Illuminate\Database\Collection
     **/
    public function search(Request $request)
    {
        return $this->repository->orders()->where(function ($query) use ($request) {
            return $query->where('invoiced', null)->where('reference_no', 'like', '%'.$request->get('query').'%');
        })->get()
        ->map(function ($lpo) {
            return ['value' => $lpo->reference_no."[ {$lpo->supplier->supplier_name}]", 'data' => $lpo->reference_no];
        })->pipe(function ($result) use ($request) {
            return [
                    'query' => $request->get('query'),
                    'suggestions' => $result->all(),
            ];
        });
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
                $pdf = app('snappy.pdf.wrapper')->loadView('reports.purchase-orders-report', ['orders' => $data['orders']->get(), 'title' => $data['title']])->setOrientation('landscape');

                return $print == 'download' ? $pdf->download('purchase-orders-report.pdf') : $pdf->inline('purchase-orders-report.pdf');
            } catch (\Exception $e) {
                return view('reports.purchase-orders-report', ['orders' => $data['orders']->get()]);
            }
        }
        // dd($data);
        // Paginate the result for a better viewing experience
        $data['orders'] = $data['orders']->paginate(30);
        // dd($data);

        return view('inventory.lpo-listing', $data);
    }

    /**
     * Show view for creating a new purchase order.
     *
     * @return Illuminate\Http\Response
     **/
    public function createPurchaseOrder()
    {
        $data = [
            'currencies' => currency(),
            'suppliers' => $this->suppliers->all(),
            'forms' => true,
            'pagetitle' => trans('main.create_lpo'),
        ];

        return view('inventory.create-purchase-order', $data);
    }

    /**
     * Save a newly created purchase order to the database.
     *
     * @param LPORequest $request
     *
     * @return \Illuminate\Http\Response
     **/
    public function savePurchaseOrder(LPORequest $request)
    {
        $data = array_merge(['type' => 'LPO', 'status' => 'draft'], $request->input());
        $order = $this->repository->create($data);
        $response = [
            'status' => 'success',
            'order' => $order,
            'message' => trans('messages.lpo_created'),
        ];
        if ($request->wantsJson()) {
            return response()->json($response);
        }

        return redirect_with_info(route('purchase_order.add_items', $order->id), $response['message']);
    }

    /**
     * Save a newly created order item to the database.
     *
     * @param Invoice $order
     *
     * @return \Illuminate\Http\Response
     **/
    public function savePurchaseOrderItems(Invoice $order)
    {
        $order->status = 'Pending';
        $order->save();
        $response = [
            'status' => 'success',
            'order' => $order,
            'message' => trans('messages.lpo_created'),
        ];
        if (request()->wantsJson()) {
            return response()->json($response);
        }

        return redirect_with_info(route('purchase_order.show', $order->id), $response['message']);
    }

    /**
     * Show purchase order view for adding new items.
     *
     * @param Ivoice $lpo
     *
     * @return Illuminate\Http\Response
     **/
    public function addItems(Invoice $lpo)
    {
        $items = $lpo->lpoItems;
        $forms = true;

        return view('inventory.purchase-order-add-items', compact('lpo', 'items', 'forms'));
    }

    /**
     * Show view for editing order.
     *
     * @param Ivoice $order
     *
     * @return Illuminate\Http\Response
     **/
    public function editPurchaseOrder(Invoice $order)
    {
        $data = [
            'forms' => true,
            'pagetitle' => trans('main.edit_lpo', ['lpo' => $order->reference_no]),
            'suppliers' => $this->suppliers->all(),
            'currencies' => currency(),
            'order' => $order,
        ];

        return view('inventory.edit-purchase-order', $data);
    }

    /**
     * Show view for displaying a purchase order.
     *
     * @param Ivoice $lpo
     **/
    public function showLPO(Invoice $lpo)
    {
        $items = $lpo->lpoItems;

        return view('inventory.purchase-order', compact('lpo', 'items'));
    }

    /**
     * Add an item to a purchase order.
     *
     * @param Invoice $lpo
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     **/
    public function addLPOItem(Invoice $lpo, LPOItemRequest $request)
    {
        $lpo->lpoItems()->updateOrCreate($request->only('product_id'), array_merge(['notes' => $request->get('notes', 'N/A')], $request->input()));

        return ['status' => 'success', 'message' => 'Item added successfully'];
    }

    /**
     * Update an item on a Purchase order.
     *
     * @param PurchaseOrderItem $item
     * @param Request           $request
     *
     * @return Illuminate\Http\Response
     * */
    public function updateLPOItem(PurchaseOrderItem $item, LPOItemRequest $request)
    {
        $item->update($request->input());

        return ['status' => 'success', 'message' => 'Item Updated successfully'];
    }

    /**
     * Show view  for editing a purchase order item.
     *
     * @return Illuminate\Http\Response
     **/
    public function editLPOItem(PurchaseOrderItem $item)
    {
        return view('inventory.modals.edit-lpo-item', compact('item'));
    }

    /**
     * Delete an item from the database.
     *
     * @return Illuminate\Http\Response
     **/
    public function deleteLPOItem(PurchaseOrderItem $item)
    {
        if ($item->delete()) {
            return ['status' => 'success', 'message' => 'Item was delted successfully'];
        }
    }

    /**
     * Update a purchase order in the database.
     *
     * @param LPORequest $request
     * @param Invoice    $order
     *
     * @return \Illuminate\Http\Response
     **/
    public function updatePurchaseOrder(LPORequest $request, Invoice $order)
    {
        $order->update($request->input());
        $order->address->update($request->input());
        $response = [
            'status' => 'success',
            'order' => $order,
            'message' => trans('messages.lpo_updated'),
        ];
        if ($request->wantsJson()) {
            return response()->json($response);
        }

        return redirect_with_info(route('purchase_order.show', $order->id), $response['message']);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function invoicePurchaseOrder(Invoice $order)
    {
        if (\Bouncer::allows('manage_purchase_orders')) {
            $items = Stock::where('lpo_number', $order->reference_no)->get();
            $invoice = Invoice::where('lpo_number', $order->reference_no)->first();
            if (count($items) > 0 && null == $invoice) {
                $data = [
                    'lpo_number' => $order->reference_no,
                    'supplier_id' => $order->supplier_id,
                    'type' => 'Invoice',
                    'currency_id' => $order->currency_id,
                    'status' => 'inv',
                    'invoiced' => true,
                ];

                $invoice = Invoice::create($data);
                foreach ($items as $key => $item) {
                    $invoice->items()->create([
                        'product_id' => $item->product_id,
                        'qty' => $item->qty,
                        'unit_cost' => $item->buying_price,
                    ]);
                }

                $order->invoiced = true;
                $order->save();
            }
            if (!count($items)) {
                return with_info(
                    'There are no stock items to invoice. Make sure that the stock is added',
                    'error',
                    'Stock Items Empty'
                );
            }

            return redirect()->route('purchase_order.invoice', $order->id);
        }
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function showInvoice(Invoice $order)
    {
        $invoice = Invoice::where('lpo_number', $order->reference_no)->first();

        return view('inventory.edit-invoice', ['invoice' => $invoice, 'pagetitle' => 'Supplier Invoice']);
    }

    /**
     * Show view for adding an invoice payment.
     *
     * @param Invoice $invoice
     **/
    public function addPayment(Invoice $invoice)
    {
        return view('inventory.modals.pay-invoice', ['invoice' => $invoice]);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function payInvoice(Request $request, Invoice $invoice)
    {
        $this->validate($request, ['amount' => 'required|numeric|between:0,'.$invoice->due]);

        $payment = $invoice->payments()->create($request->only('amount', 'notes'));
        $payment->status = 'Expense';
        $payment->save();
        $invoice->status = $invoice->due == 0 ? 'Fully Paid' : 'Partially Paid';
        $invoice->save();

        return with_info('Invoice payment has been added');
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function receiveStock(PurchaseOrderItem $item)
    {
        $product = $item->product;

        return view('stock.add-stock-from-order', compact('product', 'item'));
    }
}
