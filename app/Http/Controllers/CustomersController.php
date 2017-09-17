<?php

namespace App\Http\Controllers;

use App\Entities\Person;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Person eloquent model.
     *
     * @var Person
     **/
    protected $customer;

    /**
     * Instaite a new controller object.
     *
     * @param Person $customer
     **/
    public function __construct(Person $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Show View for creating a new customer.
     *
     * @return Illuminate\Http\Response
     **/
    public function create()
    {
        return view('customers.modals.create');
    }

    /**
     * Store a new customer to the database.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     **/
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:64',
            'phone_number' => 'nullable|string|max:25',
        ];
        $this->validate($request, $rules);
        $customer = collect($request->input())
            ->merge(['role' => 'Customer'])
            ->pipe(function ($input) {
                return $this->customer->create($input->all());
            });
        if ($request->wantsJson()) {
            return $customer;
        }

        return redirect_with_info(route('customers.index'));
    }

    /**
     * Search for a customer for autocomplete plugin.
     *
     * @param Request $request
     *
     * @return null|array Search results
     **/
    public function searchCustomer(Request $request)
    {
        return $this->customer->where('name', 'like', '%'.$request->get('query').'%')
            ->where('role', 'Customer')->get()
            ->map(function ($customer) {
                return [
                        'value' => $customer->name.'[ '.$customer->email.']',
                        'data' => $customer,
                    ];
            })->pipe(function ($result) use ($request) {
                return [
                    'query' => $request->get('query'),
                    'suggestions' => $result,
                ];
            });
    }
}
