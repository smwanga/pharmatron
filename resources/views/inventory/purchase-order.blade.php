@extends('layouts.app')
    @section('content')
        <div class="grid simple vertical green">
            <div class="tiles white add-margin">
                <div class="p-t-20 p-l-20 p-r-20 p-b-20">
                    <div class="row">
                        <div class="col-sm-8">
                          <div class="col-xs-3">
                            <img src="/img/logo.jpg" width="100" height="100" class="invoice-logo" alt="">
                          </div>
                          <div class="col-xs-9">
                            @include('partials.company-address')
                          </div>
                        </div>
                    <div class="col-sm-4">
                        <div class="well well-small green row">
                            <strong>@lang('main.purchase_order')</strong><br>
                            @lang('main.ref_no') : {{$lpo->reference_no}}<br>
                            @lang('main.delivery_date'): {{optional($lpo->delivery_date)->format('l d M Y')}}<br>
                        </div>
                        
                    </div>
                  </div>
                  <br>
                  <div class="row">
                      <div class="col-sm-8">
                            <h4 class="semi-bold">@lang('main.prepared_for')</h4>
                            <address>
                                <strong>{{optional($lpo->supplier)->supplier_name}}</strong><br>
                                {{optional($lpo->supplier)->supplier_address}}<br>
                                {{optional($lpo->supplier)->supplier_email}}<br>
                                <abbr title="Phone">P:</abbr> {{optional($lpo->supplier)->supplier_phone}}
                            </address>
                        </div>
                        <div class="col-sm-4">
                            <h4 class="semi-bold">@lang('main.delivery_address')</h4>
                            <address>
                                <strong>{{optional($lpo->address)->name}}</strong><br>
                                {{optional($lpo->address)->street}}, {{optional($lpo->address)->address_line1}}<br>
                                {{optional($lpo->address)->city}}, {{optional($lpo->address)->zip_code}}<br>
                            </address>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row b-grey">
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
                                    <td>{{$item->unit_cost}}</td>
                                    <td class="total">{{number_format($item->qty * $item->unit_cost, 2)}}</td>
                               </tr>
                               @endforeach
                           </tbody>
                        </table>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="85%" class="text-right"><strong>@lang('main.grand_total'): Ksh.</td>
                                    <td width="15%"> <strong id="grand-total"> {{$lpo ? number_format($lpo->lpo_total, 2) : 0}}</strong></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tiles white" id="sales_chart_alt" style="height: 260px; width: 100%; padding: 0px;">

                </div>
                
            </div>
        </div>
    @endsection
