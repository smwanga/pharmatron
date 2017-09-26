@extends('layouts.app')

@section('content')
      <div class="col-md-12 m-b-10">
          <!-- BEGIN SALES WIDGET WITH FLOT CHART -->
          <div class="tiles white add-margin">
              <div class="p-t-20 p-l-20 p-r-20 p-b-20">
                  <div class="row b-grey b-b xs-p-b-20">
                      <div class="col-md-4 col-sm-4">
                          <h4 class="text-black semi-bold">Purchase Orders</h4>
                          <small>Date filtering uses the <code>Delivery Date</code></small>
                      </div>
                          @php
                            extract(date_range(request()));
                          @endphp
                      <form id="search-form">
                      <div class="col-md-4 col-sm-4">
                        <div class="m-t-20 m-b-20">
                            <input value="{{request()->get('range', "$from to $to")}}" type="text" name="range" class="form-control range" placeholder="@lang('main.delivery_date')">
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-4">
                          <div class="m-t-20 m-b-20">
                              
                                  <div class="input-group">
                                      <input placeholder="supplier or barcode or stock code or product name" name="query" value="{{request()->get('query')}}" type="text" class="form-control">
                                          <span class="input-group-addon primary" onclick="$('#search-form').submit()" style="cursor: pointer;">    
                                              <span class="arrow"></span>
                                              <i class="fa fa-search"></i>
                                              <strong>@lang('main.search')</strong>
                                          </span>
                                      </div>
                              
                          </div>
                      </div>
                      </form>
                  </div>
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
                                        <th>@lang('main.supplier')</th>
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
                                         <td>{{$order->supplier->supplier_name}}</td>
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
                                              <li><a href="{{ route('purchase_order.add_items', $order->id) }}"> <i class="fa fa-plus"></i> Add Items </a></li>
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
          </div><!-- END SALES WIDGET WITH FLOT CHART -->
    </div>
@endsection
@include('partials.date-range', compact('to', 'from'));