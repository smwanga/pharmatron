@extends('layouts.app')

@section('content')
      <div class="col-md-12 m-b-10">
          <!-- BEGIN SALES WIDGET WITH FLOT CHART -->
          <div class="tiles white add-margin">
              <div class="p-t-20 p-l-20 p-r-20 p-b-20">
                  <div class="row b-grey b-b xs-p-b-20">
                      <div class="col-sm-2">
                        @if(isset($model))
                          <h4 class="text-black semi-bold">Total Stock Value</h4>
                          <h5 class="text-success semi-bold">{{currency(app_config('currency_id'))->symbol_left}} {{number_format($stock_value, 2) }}</h5>
                          @else
                          <br><br>
                          @endif
                          @php
                            extract(date_range(request()));
                          @endphp
                      </div>
                      <div class="col-sm-7">
                          <div class="m-t-20 m-b-20">
                              <form id="search-form">
                                <div class="col-sm-5">
                                   <input value="{{request()->get('range', "$from to $to")}}" type="text" name="range" class="form-control range">
                                </div>
                                <div class="col-sm-7">
                                  <div class="input-group">
                                      <input data-toggle="tooltip" title="supplier or barcode or stock code or product name" name="query" value="{{request()->get('query')}}" type="text" class="form-control">
                                          <span class="input-group-addon primary" onclick="$('#search-form').submit()" style="cursor: pointer;">    
                                              <span class="arrow"></span>
                                              <i class="fa fa-search"></i>
                                              <strong>@lang('main.search')</strong>
                                          </span>
                                    </div>
                                  </div>
                              </form>
                          </div>
                      </div>
                      @php
                          $data = request()->input();
                          $download = array_merge($data, ['print' => 'download']);
                          $print = array_merge($data, ['print' => 'print']);
                      @endphp
                      <div class="col-sm-3">
                        <div class="btn-group m-t-20">
                            <button  onclick="location.href = '?{!!http_build_query($print)!!}'" class="btn btn-white">
                                <i class="fa fa-print"></i>
                            </button>
                            <button  onclick="location.href = '?{!!http_build_query($download)!!}'" class="btn btn-white">
                                <i class="fa fa-cloud-download"></i>
                            </button>
                        </div>
                        <div class="btn-group m-t-20">
                            <button data-toggle="dropdown" href="#" class="btn btn-white">
                                @lang('main.options') &nbsp;&nbsp;&nbsp; <i class="fa fa-caret-down"></i>
                            </button>
                              <ul class="dropdown-menu pull-right">
                                  <li>
                                      <a href="{{ route('stock.index') }}" >View All Stock</a>
                                  </li>
                                  <li>
                                      <a href="{{ route('stock.expired') }}" >View Expired</a>
                                  </li>
                                  <li>
                                      <a href="{{ route('stock.inactive') }}" >View Inactive</a>
                                  </li>
                                  <li>
                                      <a href="{{ route('stock.low_stock') }}" >View Low Stock</a>
                                  </li>
                              </ul>
                        </div>
                      </div>
                  </div>
                  <div class="row b-grey">
                      <div class="col-md-7 col-sm-7">
                          <div class="m-t-10">
                              <p class="text-black h4">{{$option}}</p>
                          </div>
                    </div>
                    <div class="col-md-5 col-sm-5">
                    </div>
                </div>
                <div class="row">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>@lang('main.product')</th>
                        <th>@lang('main.stock_code')</th>
                        <th>@lang('main.unit_cost')</th>
                        <th>@lang('main.supplier')</th>
                        <th>@lang('main.status')</th>
                        <th>@lang('main.expiry_date')</th>
                        <th>@lang('main.available_stock')</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($stock as $in_stock)
                      <tr>
                        <td class="dropdown">
                          <a data-toggle="dropdown" href="#" class="btn btn-small btn-white">
                            <i class="fa fa-ellipsis-v"></i>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a data-url="{{ route('stock.show', $in_stock->id) }}" class="ajaxModal"><i class="fa fa-eye"></i> &nbsp; @lang('main.view') </a></li>
                            @can('can_edit_stock')
                            <li><a class="ajaxModal"  data-url="{{ route('stock.edit', $in_stock->id) }}"><i class="fa fa-pencil"></i> &nbsp; @lang('main.edit') </a></li>
                            @if($in_stock->active)
                            <li><a href="{{ route('stock.deactivate', $in_stock->id) }}"><i class="fa fa-times"></i> &nbsp; @lang('main.remove_from_stock') </a></li>
                            @endif
                            @if($in_stock->is_inactive)
                            <li><a href="{{ route('stock.activate', $in_stock->id) }}"><i class="fa fa-check"></i> &nbsp; @lang('main.add_back_to_stock') </a></li>
                            @endif
                            <li><a class="delete-btn" data-name="{{$in_stock->product->item_name}}" data-url="{{ route('stock.delete', $in_stock->id) }}"><i class="fa fa-trash"></i> &nbsp; @lang('main.delete') </a></li>
                            @endcan
                          </ul>
                        </td>
                        <td>{{$in_stock->product->item_name}}</td>
                        <td>{{$in_stock->product->stock_code}}</td>
                        <td>{{number_format($in_stock->selling_price, 2)}}</td>
                        <td>{{$in_stock->supplier->supplier_name}}</td>
                        <td><label class="label label-{{$in_stock->status['class']}} text-white">{{$in_stock->status['text']}}</label></td>
                        <td>{{$in_stock->expire_at->format('d-m-Y')}}</td>
                        <td title="{{number_format($in_stock->stock_available)}} {{$in_stock->product->dispensing_unit}}" data-toggle="tooltip">
                          <?php
                                $progress = progress_bar($in_stock->qty * $in_stock->pack_size, $in_stock->stock_available); ?>
                          {{$progress['value']}}%
                          <div class="progress progress-success">
                              
                              <div data-percentage="{{$progress['value']}}%" style="width: {{$progress['value']}}%;"  class="progress-bar progress-bar-{{$progress['class']}}"></div>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <div>
                    {!! $stock->render() !!}
                  </div>
                </div>
            </div>
        </div><!-- END SALES WIDGET WITH FLOT CHART -->
    </div>
@endsection
@include('partials.date-range', compact('to', 'from'));