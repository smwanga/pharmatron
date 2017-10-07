@extends('layouts.app')

@section('content')
      <div class="col-md-12 m-b-10">
          <!-- BEGIN SALES WIDGET WITH FLOT CHART -->
          <div class="tiles white add-margin">
              <div class="p-t-20 p-l-20 p-r-20 p-b-20">
                  <div class="row b-grey b-b xs-p-b-20">
                      <div class="col-md-3 col-sm-3">
                          <h4 class="text-black semi-bold">Purchase Orders</h4>
                          <small>Date filtering uses the <code>Delivery Date</code></small>
                      </div>
                          @php
                            extract(date_range(request()));
                          @endphp
                      <form id="search-form">
                      <div class="col-md-3 col-sm-3">
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
                      <div class="col-sm-2">
                        <div class="m-t-20 m-b-20">
                          @can('create_purchase_orders')
                          <a href="{{ route('purchase_order.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New</a>
                          @endcan
                      </div>
                      </div>
                      </form>
                  </div>
                    <div class="grid simple horizontal green">
                        <div class="grid-title">
                            <strong>@lang('main.purchase_orders')</strong>
                        </div>
                        <div class="grid-body">
                          @include('inventory.partials.lpo-list')
                        </div>
                    </div>
                </div>
          </div><!-- END SALES WIDGET WITH FLOT CHART -->
    </div>
@endsection
@include('partials.date-range', compact('to', 'from'));