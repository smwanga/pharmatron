@extends('reports.stock-value')
    @section('pdf-content')
    <div class="col-sm-12">
        <h4 class="text-center">{{$title}} {{ request()->has('range') ? 'From '.request()->get('range') : ''}}</h3>
    </div>
    <div class="col-sm-12">
        <table class="table table-striped">
            <thead>
                <th>@lang('main.ref_no')</th>
                <th>@lang('main.customer_name')</th>
                <th>@lang('main.paid_amount')</th>
                <th>@lang('main.due_amount')</th>
                <th>@lang('main.total')</th>
                <th>@lang('main.date')</th>
                <th>@lang('main.user')</th>
                <th>@lang('main.company')</th>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>{{$sale->ref_number}}</td>
                    <td>{{$sale->customer_name}}</td>
                    <td>{{number_format($sale->paid, 2)}}</td>
                    <td>{{number_format($sale->due,2)}}</td>
                    <td>{{number_format($sale->total, 2) }}</td>
                    <td>{{$sale->created_at->format('Y-m-d')}}</td>
                    <td>{{optional($sale->user)->name ?: '-'}}</td>
                    <td>{{optional(optional($sale->customer)->company)->company_name ?: '-'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection