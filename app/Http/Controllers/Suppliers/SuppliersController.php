<?php

namespace App\Http\Controllers\Suppliers;

use App\Entities\Person;
use App\Entities\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Contracts\Repositories\SupplierRepository as Repository;

class SuppliersController extends Controller
{
    /**
     * Supplier repository.
     *
     * @var Repository
     **/
    protected $repository;

    /**
     * Data to be injected to the view.
     *
     * @var array
     **/
    protected $data;

    /**
     * Create a new controller object.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show view for displaying a listing of suppliers.
     *
     * @return Illuminate\View\Factory
     **/
    public function index()
    {
        $data = [
            'pagetitle' => trans('main.suppliers'),
            'suppliers' => $this->repository->all(),
        ];

        return view('suppliers.list-suppliers', $data);
    }

    /**
     * Set page data.
     *
     * @return array
     **/
    protected function setPageData(array $params)
    {
        return [
            'forms' => true,
            'pagetitle' => $params['title'],
            'titles' => [(object)
                [
                'title' => $params['title2'],
                'icon' => 'fa fa-briefcase',
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
     * Show form for creating a supplier.
     *
     * @return Illuminate\View\Factory
     **/
    public function create()
    {
        $params = [
            'title' => trans('titles.add_supplier'),
            'title2' => trans('titles.supplier_details'),
            'action' => route('suppliers.save'),
            'method' => 'post',
        ];
        $data = $this->setPageData($params);

        return view('suppliers.add-supplier', $data);
    }

    /**
     * Show form for creating a supplier.
     *
     * @return Illuminate\View\Factory
     **/
    public function edit(Supplier $supplier)
    {
        $params = [
            'title' => trans('titles.edit_supplier'),
            'title2' => trans('titles.supplier_details'),
            'action' => route('suppliers.update', $supplier->id),
            'method' => 'patch',
        ];
        $data = $this->setPageData($params);
        $data['supplier'] = $supplier;

        return view('suppliers.edit-supplier', $data);
    }

    /**
     * Show form for cdisplaying supplier profile.
     *
     * @return Illuminate\View\Factory
     **/
    public function show(Supplier $supplier)
    {
        $data = [
            'title' => $supplier->supplier_name,
            'supplier' => $supplier,
            'contacts' => $supplier->contacts()->paginate(5),
        ];

        return view('suppliers.supplier-home', $data);
    }

    /**
     * Save the user submited input to database.
     *
     * @param SupplierRequest $request
     *
     * @return Illuminate\Http\Response
     **/
    public function store(SupplierRequest $request)
    {
        $supplier = $this->repository->create($request->input());

        return with_info();
    }

    /**
     * Update supplier details.
     *
     * @param SupplierRequest $request
     *
     * @return Illuminate\Http\Response
     **/
    public function update(Request $request, Supplier $supplier)
    {
        $rules = [
            'supplier_email' => 'nullable|email|unique:suppliers,supplier_email,'.$supplier->id,
            'supplier_name' => 'required|string',
            'supplier_phone' => 'required|unique:suppliers,supplier_phone,'.$supplier->id,
            'supplier_website' => 'nullable|string|url',
        ];
        $this->validate($request, $rules, SupplierRequest::getMessages());
        $supplier->update($request->input());

        return redirect_with_info(route('suppliers.show', $supplier->id));
    }

    /**
     * Show view for adding a contact.
     *
     * @param Supplier $supplier
     **/
    public function addContact(Supplier $supplier)
    {
        return view('suppliers.modals.add-contact', compact('supplier'));
    }

    /**
     * Show view for adding a contact.
     *
     * @param Supplier $supplier
     **/
    public function editContact(Person $contact)
    {
        return view('suppliers.modals.edit-contact', compact('contact'));
    }

    /**
     * Save a new contact  to the datastore.
     *
     * @param Supplier $supplier
     **/
    public function saveContact(Supplier $supplier, Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:64|unique:people',
            'phone_number' => 'required|string|max:25|unique:people',
            'address' => 'nullable|string|max:35',
        ];
        $this->validate($request, $rules);
        $contact = collect($request->input())
            ->merge(['role' => 'Supplier'])
            ->pipe(function ($input) use ($supplier) {
                return $supplier->contacts()->create($input->all());
            });
        $response = [
                'status' => 'success',
                'message' => trans('messages.contact_created', [
                    'supplier' => $supplier->supplier_name,
                ]),
                'contact' => $contact,
            ];
        if ($request->wantsJson()) {
            return $response;
        }

        return redirect_with_info(route('suppliers.show', $supplier->id), $response['message']);
    }

    /**
     * Update contact details in the datastore.
     *
     * @param Supplier $supplier
     **/
    public function updateContact(Person $contact, Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:64|unique:people,email,'.$contact->id,
            'phone_number' => 'required|string|max:25|unique:people,phone_number,'.$contact->id,
            'address' => 'nullable|string|max:35',
        ];
        $this->validate($request, $rules);
        $contact->update($request->only(array_keys($rules)));
        $response = [
                'status' => 'success',
                'message' => trans('messages.contact_updated'),
                'contact' => $contact,
            ];
        if ($request->wantsJson()) {
            return $response;
        }

        return redirect_with_info(route('suppliers.show', $supplier->id), $response['message']);
    }

    /**
     * Delete a contact from the datastore.
     *
     * @param Supplier $supplier
     **/
    public function deleteContact(Person $contact)
    {
        if ($contact->delete()) {
            return ['status' => 'success', 'message' => trans('messages.contact_delete')];
        }
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function purchaseOrders(Supplier $supplier)
    {
        $orders = $supplier->invoices()->ofType('LPO')->paginate();

        return view('suppliers.supplier-orders', compact('supplier', 'orders'));
    }
}
