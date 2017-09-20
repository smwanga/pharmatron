@extends('layouts.app')

@section('content')
      <div class="col-md-12 m-b-10">
          <!-- BEGIN SALES WIDGET WITH FLOT CHART -->
          <div class="tiles white add-margin">
              <div class="p-t-20 p-l-20 p-r-20 p-b-20">
                  <div class="row b-grey b-b xs-p-b-20">
                      <div class="col-md-4 col-sm-4">
                          <h4 class="text-black semi-bold">Total Stock Value</h4>
                          <h3 class="text-success semi-bold">{{number_format($stock_value, 2) }}</h3>
                      </div>
                      <div class="col-md-3 col-sm-3">
                          <div class="m-t-20">
                              <h5 class="text-black semi-bold">Total due</h5>
                              <h4 class="text-success semi-bold">$4,653</h4>
                          </div>
                      </div>
                      <div class="col-md-5 col-sm-5">
                          <div class="m-t-20">
                              <input type="text" class="dark form-control" id="txtinput3" placeholder="Search">
                          </div>
                      </div>
                  </div>
                  <div class="row b-grey">
                      <div class="col-md-3 col-sm-3">
                          <div class="m-t-10">
                              <p class="text-danger">Expired Stock</p>
                              <p class="text-black">2</p>
                          </div>
                      </div>
                      <div class="col-md-4 col-sm-4">
                        <div class="m-t-10">
                            <p class="text-warning">Out Of Stock</p>
                            <p class="text-black">2</p>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5">
                        <div class="m-t-10">
                            <p class="text-info">Critical Level</p>
                            <p class="text-black">3</p>
                        </div>
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
                          <a data-toggle="dropdown" href="#" class="btn btn-mini btn-white">
                            <i class="fa fa-ellipsis-v"></i>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a data-url="{{ route('stock.show', $in_stock->id) }}" class="ajaxModal"><i class="fa fa-eye"></i> &nbsp; @lang('main.view') </a></li>
                            <li><a class="ajaxModal"  data-url="{{ route('stock.edit', $in_stock->id) }}"><i class="fa fa-pencil"></i> &nbsp; @lang('main.edit') </a></li>
                            <li><a href="#"><i class="fa fa-times"></i> &nbsp; @lang('main.remove_from_stock') </a></li>
                          </ul>
                        </td>
                        <td>{{$in_stock->product->generic_name}}</td>
                        <td>{{$in_stock->product->stock_code}}</td>
                        <td>{{number_format($in_stock->selling_price, 2)}}</td>
                        <td>{{$in_stock->supplier->supplier_name}}</td>
                        <td><label class="label label-success text-white">{{$in_stock->status['text']}}</label></td>
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
                </div>
            </div>
        </div><!-- END SALES WIDGET WITH FLOT CHART -->
    </div>
@endsection