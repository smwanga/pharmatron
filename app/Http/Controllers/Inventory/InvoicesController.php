<?php

namespace App\Http\Controllers\Inventory;

use App\Entities\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests\LPORequest;
use App\Entities\PurchaseOrderItem;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\InvoiceRepository;
use App\Contracts\Repositories\SupplierRepository;

class InvoicesController extends Controller
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
    public function index()
    {
        $data = [
            'invoices' => $this->repository->invoices(),
        ];
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
        return $this->repository->all(function ($query) use ($request) {
            return $query->where('reference_no', 'like', '%'.$request->get('query')).'%';
        });
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
        $invoice = $this->repository->create($request->input());
        $invoice->type = 'LPO';
        $invoice->status = 'draft';
        $invoice->save();
        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'invoice' => $invoice, 'message' => trans('messages.lpo_created')]);
        }
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
    public function addLPOItem(Invoice $lpo, Request $request)
    {
        $rules = [
            'product_name' => 'required|string|max:255',
            'qty' => 'required|numeric|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'notes' => 'string|max:255',
        ];
        $this->validate($request, $rules);
        $lpo->lpoItems()->create($request->input());

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
    public function updateLPOItem(PurchaseOrderItem $item, Request $request)
    {
        $rules = [
            'product_name' => 'required|string|max:255',
            'qty' => 'required|numeric|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'notes' => 'string|max:255',
        ];
        $this->validate($request, $rules);
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
}
