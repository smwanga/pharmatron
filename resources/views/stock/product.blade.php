@extends('layouts.app')
    @section('content')
        <div class="container-fluid">
            <div class="grid simple vertical green">
                <div class="grid-title no-border">
                    <h4>Product General <span class="semi-bold">Information</span></h4>
                    <div class="tools">
                      <a href="javascript:;" class="collapse"></a>
                      <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle config">
                        @include('partials.product-menu')
                      </a>
                      <a href="javascript:;" class="reload"></a>
                      <a href="javascript:;" class="remove"></a>
                    </div>
                  </div>
                <div class="grid-body no-bodder">
                    <div class="message-sender text-justify">
                        {{$product->description or trans('messages.empty_description') }}     
                    </div>
                    <hr/>
                    <div class="row-fluid">
                        <div class="tiles white add-margin">
                            <div class="p-t-20 p-l-20 p-r-20 p-b-20">
                      <div class="row b-grey b-b xs-p-b-20">
                        <div class="col-md-4 col-sm-4">
                          <h4 class="text-black semi-bold">@lang('main.available_stock')</h4>
                          <h3 class="semi-bold">{{number_format($product->available_stock)}} {{str_plural($product->dispensing_unit, $product->available_stock)}}</h3>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h4 class="text-black semi-bold">@lang('main.month_sales')</h4>
                            <h3 class="semi-bold">{{ $product->monthlySales(date('m'))->count() }}</h3>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h4 class="text-black semi-bold">@lang('main.stock_value')</h4>
                            <h3 class="semi-bold">{{app_cry()->symbol_left}}: {{ $product->stock_value}} </h3> 
                        </div>
                      </div>
                      <div class="row b-grey">
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <div class="m-t-10">
                            <p class="text-success">@lang('main.generic_name')</p>
                            <p class="text-black">{{$product->generic_name}}</p>
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <div class="m-t-10">
                            <p class="text-success">@lang('main.product_code')</p>
                            <p class="text-black">{{$product->stock_code}}</p>
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <div class="m-t-10">
                            <p class="text-success">@lang('main.dispense_unit')</p>
                            <p class="text-black">{{$product->dispensing_unit}}</p>
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <div class="m-t-10">
                            <p class="text-success">@lang('main.alert_level')</p>
                            <p class="text-black">{{$product->alert_level}}</p>
                          </div>
                        </div>

                      </div>
                    </div>
                    <hr>
                    <div class="tiles white">
                        <div class="row">
                          <div class="sales-graph-heading">
                            <div class="col-md-8 col-sm-8 text-center">
                              <h5 class="semi-bold">@lang('main.instructions')</h5>
                              <p>{{$product->instructions or trans('messages.empty_instructions')}}</p>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center">
                            <h5 class="no-margin">{{$product->item_name}}</h5>
                              <center>
                              <img class="img-responsive barcode" align="center">
                              </center>
                            </div>
                            <div class="clearfix"></div>
                          </div>
                        </div>
                        <hr>
                        <h5 class="semi-bold m-t-30 m-l-30">@lang('main.stock_movement')</h5>
                        <table class="table no-more-tables m-t-20 m-l-20 m-b-30">
                          <thead>
                            <tr>
                              <th>@lang('main.date')</th>
                              <th>@lang('main.qty')</th>
                              <th>@lang('main.stock_value')</th>
                              <th>@lang('main.user')</th>
                              <th>@lang('main.comment') </th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($movement as $stock)
                            <tr>
                              <td>
                                {{$stock->created_at->format('d-m-Y')}}
                              </td>
                              <td>
                                {{$stock->qty}}
                              </td>
                              <td>
                                {{$stock->on_stock}}
                              </td>
                              <td>
                                {{$stock->user->name}}
                              </td>
                              <td>{{$stock->comment}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>               
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection
    @push('scripts')
    <script type="text/javascript">
        JsBarcode(".barcode", "{{$product->barcode}}")
        $('.barcode').css('height', 60).css('width', 180);
    </script>
    @endpush