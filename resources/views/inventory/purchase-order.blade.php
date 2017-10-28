@extends('layouts.app')
    @section('content')
        <div class="grid simple ">
              <div class="p-l-20 p-r-20 p-b-20 hidden-print">
                <div class="row">
                    <button class="btn btn-primary pull-right" onclick="print()">
                        <i class="fa fa-print"></i>  
                        Print Order
                    </button>
                  </div>
              </div>
            <div class="tiles white add-margin">
                <div class="p-t-20 p-l-20 p-r-20 p-b-20">
                    <div class="row">
                        <div class="col-xs-8">
                          <div class="col-xs-3">
                            <img src="{{asset('img/150-150-logo.png')}}" width="100" height="100" class="invoice-logo" alt="">
                          </div>
                          <div class="col-xs-9">
                            @include('partials.company-address')
                          </div>
                        </div>
                    <div class="col-xs-4">
                        <div class="well well-small green row">
                            <span class="h4">@lang('main.purchase_order')</span><br>
                            @lang('main.ref_no') : {{$lpo->reference_no}}<br>
                            @lang('main.delivery_date'): {{optional($lpo->delivery_date)->format('l d M Y')}}<br>
                        </div>
                        
                    </div>
                  </div>
                  <br>
                  <div class="row">
                      <div class="col-xs-8">
                            <h4 class="semi-bold">@lang('main.prepared_for')</h4>
                            <address>
                                <span class="semi-bold">{{optional($lpo->supplier)->supplier_name}}</span><br>
                                {{optional($lpo->supplier)->supplier_address}}<br>
                                {{optional($lpo->supplier)->supplier_email}}<br>
                                <abbr title="Phone">P:</abbr> {{optional($lpo->supplier)->supplier_phone}}
                            </address>
                        </div>
                        <div class="col-xs-4">
                            <h4 class="semi-bold">@lang('main.delivery_address')</h4>
                            <address>
                                <span class="semi-bold">{{optional($lpo->address)->name}}</span><br>
                                {{optional($lpo->address)->street}}, {{optional($lpo->address)->address_line1}}<br>
                                {{optional($lpo->address)->city}}, {{optional($lpo->address)->zip_code}}<br>
                            </address>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-sm-12" id="error-messages">
                          
                        </div>
                        <table id="lpo-table" class="table table-condensed">
                           <thead>
                               <tr>
                                   <th>#</th>
                                   <th>@lang('main.item_name')</th>
                                   <th>@lang('main.description')</th>
                                   <th>@lang('main.pack_size')</th>
                                   <th>@lang('main.qty')</th>
                                   <th>@lang('main.received_qty')</th>
                                   <th>@lang('main.price')</th>
                                   <th>@lang('main.total')</th>
                                   
                               </tr>
                           </thead> 
                           <tbody id="lpo-body">
                            <?php $key = 0; ?>
                               @foreach($items as $item)
                               <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$item->product_name}}</td>
                                    <td><span class="text-muted">{{$item->notes}}</span></td>
                                    <td>{{$item->pack_size}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>{{$item->received_qty}}</td>
                                    <td>{{$item->unit_cost}}</td>
                                    <td class="total">{{number_format($item->qty * $item->unit_cost, 2)}}</td>
                                    @if($item->product)
                                    <td class="hidden-print">
                                      <a href="{{ route('purchase_order.receive_stock', $item->id) }}" class="btn btn-success btn-small">@lang('main.receive')</a>
                                    </td>
                                    @endif
                               </tr>
                               @endforeach
                           </tbody>
                        </table>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="85%" class="text-right"><span class="h4">@lang('main.grand_total'): {{currency($lpo->currency_id)->symbol_left}}.</span></td>
                                    <td width="15%"> <span class="h5" id="grand-total"> {{$lpo ? number_format($lpo->lpo_total, 2) : 0}}</span></td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <div class="col-sm-12 m-b-20">
                            <p class="h5 text-center">
                              {{$lpo->notes}}
                            </p>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    @endsection
