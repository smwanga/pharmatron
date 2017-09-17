@extends('layouts.app')
    @section('content')
            <div class="col-md-11">
              <div class="grid simple">
                <div class="grid-body no-border invoice-body">
                  <div class="col-xs-3 pull-right hidden-print m-r-0">
                      <div class="ribbon-content">
                          <div class="ribbon {{$ribbon['class']}}"><span><i class="fa fa-money"></i> &nbsp; {{$ribbon['message']}}</span></div>
                      </div>
                  </div> 
                  <br>
                  <div class="pull-left"> <img src="/assets/img/invoicelogo.png" data-src="/assets/img/invoicelogo.png" data-src-retina="/assets/img/invoicelogo2x.png" width="222" height="31" class="invoice-logo" alt="">
                  </div>
                  <div class="pull-right">
                    <h2>Invoice</h2>
                  </div>
                  <div class="clearfix"></div>
                  <br>
                  <br>
                  <br>
                  <div class="row">
                    <div class="col-sm-9 col-xs-12">
                      <address class="col-sm-6">
                        <strong>Pharmatron Chemists</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        <abbr title="Phone">P:</abbr> (123) 456-7890
                      </address>
                      @if($sale->customer_name)
                      <address class="col-sm-6">
                        Customer: <br>
                        {{$sale->customer_name}}
                      </address>
                      @endif
                      <hr>
                    </div>
                    <div class="col-sm-3 col-xs-12">
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
                      <div class="well well-small green">
                        <div class="pull-right"> Ksh. {{number_format($sale->due, 2)}} </div>
                        <div class="pull-right"> Total Due : &nbsp; &nbsp;</div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                  <table class="table">
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
                        <td colspan="3" rowspan="4">
                       {{--  <h4 class="semi-bold">terms and conditions</h4>
                        <p>Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.</p> --}}
                          <h5 class="text-right semi-bold">Thank you for shopping with us</h5></td>
                        <td class="text-right"><strong>Subtotal</strong></td>
                        <td class="text-right">Ksh. {{number_format($sale->sub_total, 2)}}</td>
                      </tr>
                      <tr>
                        <td class="text-right no-border"><strong>Discount</strong></td>
                        <td class="text-right">Ksh. {{number_format($sale->discount_amount, 2)}}</td>
                      </tr>
                      <tr>
                        <td class="text-right no-border"><strong>VAT Included in Total</strong></td>
                        <td class="text-right">Ksh. {{number_format($sale->tax_amount, 2)}}</td>
                      </tr>
                      <tr>
                        <td class="text-right no-border">
                          <div class="well well-small"><strong>Total</strong></div>
                        </td>
                        <td class="text-right"><strong>Ksh.{{number_format($sale->total, 2)}}</strong></td>
                      </tr>
                    </tbody>
                  </table>
                  <br>
                  <br>
                  <h5 class="text-right text-black">Your Were served by:</h5>
                  <h5 class="text-right semi-bold text-black">{{optional($sale->user)->name}}</h5>
                  <br>
                  <br>
                </div>
              </div>
            </div>
            <div class="col-md-1 hidden-print">
              <div class="invoice-button-action-set">
                <p>
                  <button onclick="window.print();" class="btn btn-primary" type="button"><i class="fa fa-print"></i></button>
                </p>
                <p>
                  @if($sale->due > 0)
                  <button data-url="{{ route('sales.invoice.pay', $sale->id) }}" data-toggle="tooltip" title="Accept Payment" class="btn btn-success ajaxModal" type="button"><i class="fa fa-credit-card"></i></button>
                  @endif
                </p>
              </div>
            </div>
          </div>
    @endsection