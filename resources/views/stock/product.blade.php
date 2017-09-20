@extends('layouts.app')
    @section('content')
        <div class="container-fluid">
            <div class="grid simple vertical green">
                <div class="grid-title no-border">
                    <h4>Product General <span class="semi-bold">Information</span></h4>
                    <div class="tools">
                      <a href="javascript:;" class="collapse"></a>
                      <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle config">
                        <ul class="dropdown-menu pull-right">
                          <li>
                            <a href="#"> <i class="fa fa-pencil m-r-xs"></i> &nbsp; @lang('main.edit_product')</a>
                          </li>
                          <li> 
                            <a href="{{ route('stock.create', $product->id) }}"> <i class="fa fa-folder-open m-r-xs"></i> &nbsp; @lang('main.adjust_stock')</a>
                            </li>
                          <li>  
                            <a href="#"> <i class="fa fa-bar-chart m-r-xs"></i> &nbsp; @lang('main.view_stock_movement')</a> 
                            </li>
                          <li> 
                            <a href="#"> <i class="fa fa-barcode m-r-xs"></i> &nbsp; @lang('main.print_barcodes')</a>
                            </li>
                          <li> 
                            <a href="{{ route('stock.create', $product->id) }}"> <i class="fa fa-plus m-r-xs"></i> &nbsp; @lang('main.add_stock')</a>
                            </li>
                          <li> 
                            <a href="#"> <i class="fa fa-trash m-r-xs"></i> &nbsp; @lang('main.delete')</a>
                          </li>
                        </ul>
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
                          <h4 class="text-black semi-bold">Available In stock</h4>
                          <h3 class="semi-bold">{{number_format($product->available_stock)}} {{str_plural($product->dispensing_unit, $product->available_stock)}}</h3>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h4 class="text-black semi-bold">Sales</h4>
                            <h3 class="semi-bold">1,900</h3>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h4 class="text-black semi-bold">Stock Value</h4>
                            <h3 class="semi-bold">Ksh: {{ $product->stock_value}} </h3> 
                        </div>
                      </div>
                      <div class="row b-grey">
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <div class="m-t-10">
                            <p class="text-success">@lang('main.category')</p>
                            <p class="text-black">{{$product->category->category}}</p>
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
                            <div class="col-md-4 col-sm-4 text-center">
                              <h5 class="semi-bold">@lang('main.instructions')</h5>
                              <p>{{$product->instructions or trans('messages.empty_instructions')}}</p>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center">
                              <h5 class="semi-bold">@lang('main.notes')</h5>
                              <p>{{$product->notes or trans('messages.empty_notes')}}</p>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center">
                            <h5 class="no-margin">{{$product->generic_name}}</h5>
                              <center>
                              <img class="img-responsive barcode" align="center">
                              </center>
                            </div>
                            <div class="clearfix"></div>
                          </div>
                        </div>
                        <hr>
                        <h5 class="semi-bold m-t-30 m-l-30">@lang('main.available_stock')</h5>
                        <table class="table no-more-tables m-t-20 m-l-20 m-b-30">
                          <thead>
                            <tr>
                              <th>@lang('main.ref_number')</th>
                              <th>@lang('main.stock_value')</th>
                              <th>@lang('main.expiry_date')</th>
                              <th>@lang('main.available_stock') </th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($product->stock()->available()->take(10)->get() as $stock)
                            <tr>
                              <th class="visible-xs">@lang('main.ref_number')</th>
                              <td class="v-align-middle bold text-success">{{$stock->ref_number}}</td>
                               <th class="visible-xs">@lang('main.stock_value')</th>
                              <td class="v-align-middle"><span class="muted">KES {{number_format($stock->available()->stockValue())}}</span> </td>
                              <th class="visible-xs">@lang('main.expiry_date')</th>
                              <td><span class="muted bold text-success">{{$stock->expire_at->format('d-m-Y')}}</span> </td>
                              <th class="visible-xs">@lang('main.available_stock')</th>
                              <td class="v-align-middle">{{$stock->stock_available}}</td>
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
        $('.barcode').css('height', 70).css('width', 180);
    </script>
    @endpush