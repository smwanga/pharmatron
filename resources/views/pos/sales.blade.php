@extends('layouts.app')
    @section('content')
        <div class="col-md-12">
              <div class="grid simple ">
                <div class="grid-title no-border">
                  <h4>Sales and   <span class="semi-bold">Draft Sales</span></h4>
                  <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="#grid-config" data-toggle="modal" class="config"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                  </div>
                </div>
                @php
                  extract(date_range(request()));

                  $btns = [
                      [
                          'icon' => 'fa fa-plus',
                          'text' => trans('main.add_new'),
                          'class' => 'btn-lg btn-primary',
                          'url' => route('sales.index')
                      ]
                  ]; 
                @endphp
                <div class="grid-body no-border">
                  <div class="col-sm-12 m-t20 m-b-20">
                    <form id="sales-search">
                    <div class="col-sm-4 form-group">
                          <input value="{{request()->get('range', "$from to $to")}}" type="text" name="range" class="form-control range input-sm">
                    </div>
                    <div class="col-sm-5 form-group">
                     <div class="input-group">
                      <input value="{{request()->get('query')}}" type="text" class="input-sm form-control" data-toggle="tooltip" name="query" placeholder="Search Query" title="Customer name or Invoice Number">
                      <span class="input-group-addon primary" style="cursor: pointer;" onclick="$('#sales-search').submit()">    
                        <span class="arrow"></span>
                      <i class="fa fa-filter"></i>
                       Filter
                      </span>
                    </div>
                    </div>
                  </form>
                    <div class="col-sm-3">
                        @include('partials.print-btns', ['size' => 'btn-lg', 'btns' => $btns]) 
                    </div>
                  </div>
                  <table class="table no-more-tables">
                    <thead>
                      <tr class="">
                        <th style="width:1%">
                          #
                        </th>
                        <th>Customer Name</th>
                        <th>Ref Number</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($sales as $key => $sale)
                      <tr class="">
                        <td class="v-align-middle">
                          {{++$key}}
                        </td>
                        <td class="v-align-middle">{{$sale->customer_name ?: 'Cash Sale'}}</td>
                        <td class="v-align-middle"><span class="muted">{{$sale->ref_number}}</span>
                        </td>
                        <td><span class="muted">{{number_format($sale->total, 2) }}</span>
                        </td>
                        <td class="v-align-middle">
                          <label class="label label-{{sale_ribbon($sale->due, $sale->total)['class']}}"> {{sale_ribbon($sale->due, $sale->total)['message']}}</label>
                        </td>
                        <td class="v-align-middle">
                          <label class="label label-{{$sale->meta['class']}}"> {{$sale->meta['text']}}</label>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-small dropdown btn-white btn-demo-space"><i class="fa fa-cog"></i> @lang('main.options')</button>
                              <ul class="dropdown-menu pull-right">
                                @if($sale->type == 'invoice')
                                <li><a href="{{ route('sales.invoice', $sale->id) }}">@lang('main.view')</a></li>
                                @endif
                                @if($sale->type == 'draft')
                                <li><a href="{{ route('sales.index', $sale->id) }}">@lang('main.view')</a></li>
                                @endif
                                @can('delete_sales_records')
                                <li><a data-url="{{ route('sales.delete', $sale->id) }}" href="#" class="delete-btn" data-name="Sales Record">@lang('main.delete')</a></li>
                                @endcan
                                <li class="divider"></li>
                                <li><a href="{{ route('sales.invoice.labels', $sale->id) }}">@lang('main.view_labels')</a></li>
                              </ul>
                            </div> 
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <div class="text-center">
                      {!! $sales->render() !!}
                  </div>
                </div>
              </div>
            </div>
      @endsection
      @include('partials.date-range', compact('to', 'from'));