<?php

namespace App\Http\Controllers;

use App\Entities\Stock;
use App\Entities\Payment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiles = [
                'sales_today' => Payment::getTodaySales(),
                'expenses' => Stock::getThisMonth(),
                'sales_month' => Payment::getSalesThisMonth(),
                'stock_value' => resolve('App\Contracts\Repositories\StockRepository')->getStockValue(),
        ];

        return view('home', ['tiles' => $tiles, 'pagetitle' => trans('titles.dashboard')]);
    }
}
