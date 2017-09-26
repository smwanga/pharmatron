@extends('reports.stock-value')
    @section('pdf-content')
    <div class="col-sm-12">
        <h4 class="text-center">{{$title}} {{ request()->has('range') ? 'From '.request()->get('range') : ''}}</h3>
    </div>
    <div class="col-sm-12">
        <table class="table table-striped">
            <thead>
                <th>@lang('main.stock_code')</th>
                <th>@lang('main.lpo_number')</th>
                <th>@lang('main.item_name')</th>
                <th>@lang('main.supplier')</th>
                <th>@lang('main.pack_size')</th>
                <th>@lang('main.qty')</th>
                <th>@lang('main.unit_cost')</th>
                <th>@lang('main.marked_price')</th>
                <th>@lang('main.expiry_date')</th>
                <th>@lang('main.available')</th>
                <th>@lang('main.stock_value')</th>
            </thead>
            <tbody>
                @foreach($product_stock as $stock)
                <tr>
                    <td>{{optional($stock->product)->stock_code}}</td>
                    <td>{{$stock->lpo_number or '-'}}</td>
                    <td>{{optional($stock->product)->item_name}}</td>
                    <td>{{optional($stock->supplier)->supplier_name}}</td>
                    <td>{{$stock->pack_size}}</td>
                    <td>{{$stock->qty}}</td>
                    <td>{{number_format($stock->selling_price,1)}}</td>
                    <td>{{number_format($stock->marked_price,1)}}</td>
                    <td>{{optional($stock->expire_at)->format('Y-m-d')}}</td>
                    <td>{{number_format($stock->stock_available)}}</td>
                    <td>{{number_format($stock->stock_value)}}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    @endsection