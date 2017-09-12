@extends('layouts.app')
    @section('content')
            <div class="col-md-11">
              <div class="grid simple">
                <div class="grid-body no-border invoice-body">
                  <br>
                  <div class="pull-left"> <img src="/assets/img/invoicelogo.png" data-src="/assets/img/invoicelogo.png" data-src-retina="/assets/img/invoicelogo2x.png" width="222" height="31" class="invoice-logo" alt="">
                  </div>
                  <div class="pull-right">
                    <h2>invoice</h2>
                  </div>
                  <div class="clearfix"></div>
                  <br>
                  <br>
                  <br>
                  <div class="row">
                    <div class="col-md-9">
                      <address>
                <strong>Pharmatron Chemists</strong><br>
                795 Folsom Ave, Suite 600<br>
                San Francisco, CA 94107<br>
                <abbr title="Phone">P:</abbr> (123) 456-7890
                </address>
                    </div>
                    <div class="col-md-3">
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
                        <div class="pull-left"> Total Due : </div>
                        <div class="pull-right"> Ksh. {{$sale->total}} </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                  <table class="table">
                    <thead>
                      <tr>
                        <th style="width:60px" class="unseen text-center">#</th>
                        <th class="text-left">Drug</th>
                        <th>@lang('main.qty')</th>
                        <th style="width:140px" class="text-right">UNIT PRICE</th>
                        <th style="width:90px" class="text-right">TOTAL</th>
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
                        <td colspan="2" rowspan="4">
                       {{--  <h4 class="semi-bold">terms and conditions</h4>
                        <p>Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.</p> --}}
                          <h5 class="text-right semi-bold">Thank you for shopping with us</h5></td>
                        <td class="text-right"><strong>Subtotal</strong></td>
                        <td class="text-right">Ksh. 144.00</td>
                      </tr>
                      <tr>
                        <td class="text-right no-border"><strong>Shipping</strong></td>
                        <td class="text-right">Ksh. 0.00</td>
                      </tr>
                      <tr>
                        <td class="text-right no-border"><strong>VAT Included in Total</strong></td>
                        <td class="text-right">Ksh. 0.00</td>
                      </tr>
                      <tr>
                        <td class="text-right no-border">
                          <div class="well well-small green"><strong>Total</strong></div>
                        </td>
                        <td class="text-right"><strong>Ksh. 144.00</strong></td>
                      </tr>
                    </tbody>
                  </table>
                  <br>
                  <br>
                  <h5 class="text-right text-black">Your Were served by:</h5>
                  <h5 class="text-right semi-bold text-black">John Smith</h5>
                  <br>
                  <br>
                </div>
              </div>
            </div>
            <div class="col-md-1">
              <div class="invoice-button-action-set">
                <p>
                  <button class="btn btn-primary" type="button"><i class="fa fa-print"></i></button>
                </p>
                <p>
                  <button class="btn " type="button"><i class="fa fa-cloud-download"></i></button>
                </p>
              </div>
            </div>
          </div>
    @endsection