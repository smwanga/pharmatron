<div class="col-md-12">
              <div class="grid simple">
                <div class="grid-body no-border invoice-body">
                  <div class="col-xs-12">
                          <div class="text-center">
                            @include('partials.company-address')
                          </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="row">
                    <div class="col-sm-8 hidden-print">
                      @if($sale->company)
                        @include('partials.company-details', ['company' => $sale->company])
                      @endif
                    </div>
                    <div class="col-sm-4">
                      <br>
                      <div>
                      @if($sale->customer_name)
                        <div class="pull-left text-uppercase"> @lang('main.customer'): </div>
                        <div class="pull-right"> {{$sale->customer_name}} </div>
                      @endif
                      </div>
                      <div>
                        <div class="pull-left"> INVOICE NO : </div>
                        <div class="pull-right"> {{$sale->ref_number}} </div>
                        <div class="clearfix"></div>
                      </div>
                      <div>
                        <div class="pull-left"> INVOICE DATE : </div>
                        <div class="pull-right"> {{$sale->created_at->format('d-m-Y')}} </div>
                        <div class="clearfix"></div>
                      </div>
                      <br>
                      <div class="well well-small green h5">
                        <div class="pull-right"> {{app_cry()->symbol_left}}. {{number_format($sale->due, 2)}} </div>
                        <div class="pull-right"> Total Due : &nbsp; &nbsp;</div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                  <table class="table content-data table-bordered">
                    <thead>
                      <tr>
                        <th class="unseen text-center">#</th>
                        <th class="text-left">Drug</th>
                        <th>@lang('main.qty')</th>
                        <th class="text-right">PRICE</th>
                        <th class="text-right">TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($sale->items as $key => $item)
                      <tr>
                        <td class="unseen text-center">{{++$key}}</td>
                        <td>{{optional($item->product)->item_name ?: 'N/A'}}</td>
                        <td>{{$item->qty}}</td>
                        <td class="text-right">{{$item->unit_cost}}</td>
                        <td class="text-right">{{app_cry()->symbol_left}}. {{$item->unit_cost * $item->qty}}</td>
                      </tr>
                      @endforeach
                      <tr>
                        <td colspan="3" rowspan="4">
                       {{--  <h4 class="semi-bold">terms and conditions</h4>
                        <p>Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.</p> --}}
                          <h5 class="text-center semi-bold">{{app_config('sale_footer')}}</h5></td>
                        <td class="text-right"><strong class="h5" style="font-weight: bold;">Subtotal</strong></td>
                        <td class="text-right">{{app_cry()->symbol_left}}. {{number_format($sale->sub_total, 2)}}</td>
                      </tr>
                      <tr>
                        <td class="text-right no-border"><strong class="h5" style="font-weight: bold;">Discount</strong></td>
                        <td class="text-right">{{app_cry()->symbol_left}}. {{number_format($sale->discount_amount, 2)}}</td>
                      </tr>
                      <tr>
                        <td class="text-right no-border"><strong class="h5" style="font-weight: bold;">VAT</strong></td>
                        <td class="text-right">{{app_cry()->symbol_left}}. {{number_format($sale->tax_amount, 2)}}</td>
                      </tr>
                      <tr>
                        <td class="text-right no-border">
                          <div class=""><strong class="h5" style="font-weight: bold;">Total</strong></div>
                        </td>
                        <td class="text-right"><strong class="h5">{{app_cry()->symbol_left}}.{{number_format($sale->total, 2)}}</strong></td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="col-xs-12 text-center">
                    <h5 class="text-black">Your Were served by:</h5>
                  <h5 class="semi-bold text-black" style="font-weight: bold;">{{optional($sale->user)->name}}</h5>
                  <button class="btn btn-success hidden-print" onclick="print()">Print Receipt</button>
                  </div>
                  <br>
                  <br>
                </div>
              </div>
            </div>