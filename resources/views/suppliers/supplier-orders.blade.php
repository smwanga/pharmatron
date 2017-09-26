@extends('suppliers.supplier-profile')

@section('profile-content')
<div class="row-fluid">
    <div class="grid simple horizontal green">
        <div class="grid-title">
            <strong>@lang('main.purchase_orders')</strong>
        </div>
        <div class="grid-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('main.lpo_number')</th>
                        <th>@lang('main.date_created')</th>
                        <th>@lang('main.delivery_date')</th>
                        <th>@lang('main.total')</th>
                        <th>@lang('main.status')</th>
                        <th>@lang('main.invoiced')</th>
                        <th>@lang('main.options')</th>                
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $key =>  $order)
                     <tr>
                         <td>{{++$key}}</td>
                         <td>{{$order->reference_no}}</td>
                         <td>{{$order->created_at->format('d-m-Y')}}</td>
                         <td>{{$order->delivery_date->diffForHumans()}}</td>
                         <td>{{app_cry()->symbol_left.'. '.number_format($order->lpo_total)}}</td>
                         <td>{{$order->status}}
                        <td><label class="label label-danger text-white">No</label></td>
                        <td class="text-center">
                            <button class="btn btn-white btn-mini" data-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ route('purchase_order.show', $order->id) }}"> <i class="fa fa-eye"></i> View </a></li>
                                <li><a href="{{ route('purchase_order.edit', $order->id) }}"><i class="fa fa-pencil"></i> Edit</a></li>
                            </ul>
                        </td>
                     </tr>     
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection