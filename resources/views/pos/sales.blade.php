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
                <div class="grid-body no-border">
                  <div class="col-sm-12 form-group">
                    <form id="sales-search">
                    <div class="col-sm-3 form-group">
                      <input value="{{request()->get('query')}}" type="text" name="query" class="input-sm form-control" placeholder="Customer name or Ref Number">
                    </div>
                    <div class="col-sm-3 form-group">
                      <input value="{{request()->get('from')}}" type="text" name="from" class="input-sm form-control date-picker" placeholder="date from">
                    </div>
                    <div class="col-sm-4 form-group">
                     <div class="input-group">
                      <input value="{{request()->get('to')}}" type="text" class="input-sm form-control date-picker" name="to" placeholder="date to">
                      <span class="input-group-addon primary" style="cursor: pointer;" onclick="$('#sales-search').submit()">    
           <span class="arrow"></span>
                      <i class="fa fa-filter"></i>
                       Filter
                      </span>
                    </div>
                    </div>
                  </form>
                    <div class="col-sm-2">
                        <a href="{{ route('sales.index') }}" class="btn btn-primary btn-small pull-right"><i class="fa fa-plus"></i> &nbsp; @lang('main.add_new')</a>
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
                        <td class="v-align-middle">{{$sale->customer_name}}</td>
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
                                <li><a href="{{ route('sales.invoice', $sale->id) }}">@lang('main.view')</a></li>
                                @if($sale->type == 'draft')
                                <li><a href="{{ route('sales.index', $sale->id) }}">@lang('main.edit')</a></li>
                                @endif
                                <li><a href="#">@lang('main.delete')</a></li>
                                <li class="divider"></li>
                                <li><a href="#">@lang('main.view_labels')</a></li>
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