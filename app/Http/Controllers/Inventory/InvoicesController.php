<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller
{
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
}
