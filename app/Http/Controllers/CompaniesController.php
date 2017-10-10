<?php

namespace App\Http\Controllers;

use App\Entities\Person;
use App\Entities\Company;
use Illuminate\Http\Request;
use App\Events\CompanyCreated;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateRequest;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'companies' => Company::paginate(),
            'pagetitle' => 'Company Listing',
        ];

        return view('companies.list-companies', $data);
    }

    /**
     * Show the form for creating a new company.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create-company', ['pagetitle' => trans('main.create_company')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $company = Company::create($request->input());
        event(new CompanyCreated($company));

        return redirect_with_info(route('companies.index'), "The company {$company->company_name} has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $people = $company->people();
        if ($q = request('query')) {
            $people = $people->where('name', 'like', "%{$q}%");
        }
        $data = [
            'people' => $people->paginate(),
            'pagetitle' => $company->company_name,
            'company' => $company,
            'total' => $company->invoices->map(function ($sale) {
                return $sale->total;
            })->sum(),
            'due' => $company->invoices->map(function ($sale) {
                return $sale->due;
            })->sum(),
        ];

        return view('companies.home', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit-company', ['pagetitle' => "Edit {$company->company_name}", 'company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Company             $company
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $company->update($request->input());

        return redirect_with_info(route('companies.index'), 'Company profile has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if ($company->delete()) {
            return with_info();
        }
    }

    /**
     * Show view for adding a Person.
     *
     * @param Company $company
     **/
    public function addPerson(Company $company)
    {
        return view('companies.modals.add-person', compact('company'));
    }

    /**
     * Show view for adding a Person.
     *
     * @param Person $person
     **/
    public function editPerson(Person $person)
    {
        return view('companies.modals.edit-person', compact('person'));
    }

    /**
     * Save a new Person  to the datastore.
     *
     * @param Company $company
     **/
    public function savePerson(Company $company, Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:64|unique:people',
            'phone_number' => 'required|string|max:25|unique:people',
            'address' => 'nullable|string|max:35',
        ];
        $this->validate($request, $rules);
        $person = collect($request->input())
            ->merge(['role' => 'Customer'])
            ->pipe(function ($input) use ($company) {
                return $company->people()->create($input->all());
            });
        $response = [
                'status' => 'success',
                'message' => trans('messages.customer_created', [
                    'company' => $company->company_name,
                ]),
                'person' => $person,
            ];
        if ($request->wantsJson()) {
            return $response;
        }

        return redirect_with_info(route('companies.show', $company->id), $response['message']);
    }

    /**
     * Update Person details in the datastore.
     *
     * @param Person $person
     **/
    public function updatePerson(Person $person, Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:64|unique:people,email,'.$person->id,
            'phone_number' => 'required|string|max:25|unique:people,phone_number,'.$person->id,
            'address' => 'nullable|string|max:35',
        ];
        $this->validate($request, $rules);
        $person->update($request->only(array_keys($rules)));
        $response = [
                'status' => 'success',
                'message' => trans('messages.profile_updated'),
                'person' => $person,
            ];
        if ($request->wantsJson()) {
            return $response;
        }

        return redirect_with_info(route('companies.show', $person->company_id), $response['message']);
    }

    /**
     * Delete a Person from the datastore.
     *
     * @param Person $person
     **/
    public function deletePerson(Person $person)
    {
        if ($person->delete()) {
            return ['status' => 'success', 'message' => trans('messages.person_delete')];
        }
    }

    /**
     * show credit invoice.
     *
     * @author
     **/
    public function showCompanyInvoices(Company $company)
    {
        $data = [
            'invoices' => $company->invoices()->orderBy('created_at', 'DESC')->paginate(),
            'company' => $company,
        ];

        return view('companies.invoices', $data);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function showPersonInvoices(Person $person)
    {
        $data = [
            'invoices' => $person->invoices()->orderBy('created_at', 'DESC')->paginate(),
            'company' => $person->company,
        ];

        return view('companies.invoices', $data);
    }
}
