<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * paginate results for a given set of data.
     *
     * @param Collection $items
     * @param int        $perPage [description]
     *
     * @return LengthAwarePaginator paginated results
     */
    public function paginate($items, $perPage = 15)
    {
        if (!$items instanceof Collection) {
            $items = Collection::make($items);
        }
        $page = Paginator::resolveCurrentPage();
        $total = $items->count();
        $results = $items->slice(($page - 1) * $perPage, $perPage);
        $paginate = new LengthAwarePaginator($results, $total, $perPage);

        return $paginate->setPath(request()->url());
    }
}
