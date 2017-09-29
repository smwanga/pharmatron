<div class="col-md-10">
              <div class="grid simple">
                <div class="grid-body no-border invoice-body">
                  <div class="col-xs-3 pull-right hidden-print m-r-0 hidden-sm hidden-xs">
                      <div class="ribbon-content">
                          <div class="ribbon {{$ribbon['class']}}"><span><i class="fa fa-money"></i> &nbsp; {{$ribbon['message']}}</span></div>
                      </div>
                  </div> 
                  <div class="col-xs-8">
                          <div class="col-xs-3">
                            <img src="{{asset('img/150-150-logo.png')}}" width="100" height="100" class="invoice-logo" alt="">
                          </div>
                          <div class="col-xs-9">
                            @include('partials.company-address')
                          </div>
                        </div>
                  <div class="col-xs-4">
                    <h3 class="pull-right">@lang('main.invoice')</h3>
                  </div>
                  <div class="clearfix"></div>
                  <div class="row">
                    <div class="col-sm-8 col-xs-8">
                      <div class="col-sm-6"> 
                       @if($sale->customer_name)
                      <address class="col-sm-6">
                        <h4>@lang('main.customer')</h4>
                        {{$sale->customer_name}}
                      </address>
                      @endif
                      </div>
                    </div>
                    <div class="col-sm-4 col-xs-4">
                      <br>
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
                        <div class="pull-right"> Ksh. {{number_format($sale->due, 2)}} </div>
                        <div class="pull-right"> Total Due : &nbsp; &nbsp;</div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                  <table class="table content-data">
                    <thead>
                      <tr>
                        <th class="unseen text-center">#</th>
                        <th class="text-left">Drug</th>
                        <th>@lang('main.qty')</th>
                        <th class="text-right">UNIT PRICE</th>
                        <th class="text-right">TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($sale->items as $key => $item)
                      <tr>
                        <td class="unseen text-center">{{++$key}}</td>
                        <td>{{$item->product->generic_name}}</td>
                        <td>{{$item->qty}}</td>
                        <td class="text-right">{{$item->unit_cost}}</td>
                        <td class="text-right">Ksh. {{$item->unit_cost * $item->qty}}</td>
                      </tr>
                      @endforeach
                      <tr>
                        <td colspan="3" rowspan="3">
                       {{--  <h4 class="semi-bold">terms and conditions</h4>
                        <p>Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.</p> --}}
                          <h5 class="text-right semi-bold">Thank you for shopping with us</h5></td>
                        <td class="text-right"><strong class="h5">Subtotal</strong></td>
                        <td class="text-right">Ksh. {{number_format($sale->sub_total, 2)}}</td>
                      </tr>
                      <tr>
                        <td class="text-right no-border"><strong class="h5">Discount</strong></td>
                        <td class="text-right">Ksh. {{number_format($sale->discount_amount, 2)}}</td>
                      </tr>
                      <tr>
                        <td class="text-right no-border"><strong class="h5">VAT Included in Total</strong></td>
                        <td class="text-right">Ksh. {{number_format($sale->tax_amount, 2)}}</td>
                      </tr>
                      <tr>
                        <td colspan="3">
                          <h5 class="text-left text-black">Your Were served by:</h5>
                  <h5 class="text-left semi-bold text-black">{{optional($sale->user)->name}}</h5>
                        </td>
                        <td class="text-right no-border">
                          <div class="well well-small"><strong class="h5">Total</strong></div>
                        </td>
                        <td class="text-right"><strong class="h5">Ksh.{{number_format($sale->total, 2)}}</strong></td>
                      </tr>
                    </tbody>
                  </table>
                  
                  <br>
                  <br>
                </div>
              </div>
            </div>