@extends('layouts.app')
    @section('content')
        <div class="col-sm-12 hidden-print">
          <div class="btn-group pull-right">
            @if($invoice->due > 0)
            <a data-url="{{ route('purchase_order.invoice.add_payment', $invoice->id) }}" class="ajaxModal btn btn-primary pull-right"><i class="fa fa-credit-card"></i> Pay Invoice</a>
            @endif
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="grid simple vertical green">
            <div class="tiles white add-margin">
                <div class="p-t-20 p-l-20 p-r-20 p-b-20">
                    <div class="row">
                        <div class="col-sm-8">
                          <div class="col-xs-3">
                            <img src="{{asset('img/150-150-logo.png')}}" width="100" height="100" class="invoice-logo" alt="">
                          </div>
                          <div class="col-xs-9">
                            <address>
                                <strong class="h4">{{app_config('site_name')}}</strong><br>
                                {{app_config('street')}}, {{app_config('address')}}<br>
                                {{app_config('city')}}, {{app_config('zip_code')}}<br>
                                <span><i class="fa fa-phone"></i> :</span> {{app_config('contact_phone')}}, <span><i class="fa fa-envelope-o"></i> : </span> {{app_config('contact_email')}}
                            </address>
                          </div>
                        </div>
                    <div class="col-sm-4">
                        <div class="well well-small green row">
                            <strong>INVOICE</strong><br>
                            @lang('main.ref_no') : {{$invoice->reference_no}}<br>
                            @lang('main.created_at'): {{optional($invoice->created_at)->format('l d M Y')}}<br>
                        </div>
                        
                    </div>
                  </div>
                  <br>
                  <div class="row">
                      <div class="col-sm-8">
                            <h4 class="semi-bold">PREPARED FOR</h4>
                            <address>
                                <strong>{{optional($invoice->supplier)->supplier_name}}</strong><br>
                                {{optional($invoice->supplier)->supplier_address}}<br>
                                {{optional($invoice->supplier)->supplier_email}}<br>
                                <abbr title="Phone">P:</abbr> {{optional($invoice->supplier)->supplier_phone}}
                            </address>
                        </div>
                        <div class="col-sm-4">
                            
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
                                   <th>@lang('main.qty')</th>
                                   <th>@lang('main.price')</th>
                                   <th>@lang('main.total')</th>
                               </tr>
                           </thead> 
                           <tbody id="lpo-body">
                            <?php $key = 0; ?>
                               @foreach($invoice->items as $item)
                               <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$item->product->item_name}}</td>
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
                                    <td width="80%" class="text-right"><strong>@lang('main.grand_total'): {{app_cry()->symbol_left}}.</td>
                                    <td width="20%"> <strong id="grand-total"> {{$invoice ? number_format($invoice->total, 2) : 0}}</strong></td>
                                </tr>
                                <tr>
                                    <td width="80%" class="text-right"><strong>@lang('main.due_amount'): {{app_cry()->symbol_left}}.</td>
                                    <td width="20%"> <strong id="grand-total"> {{$invoice ? number_format($invoice->due, 2) : 0}}</strong></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="row m-t-20">
                      <div class="grid simple">
                        <div class="grid-title">
                          Ivoice Payments
                        </div>
                        <div class="grid-body">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Reference Number</th>
                                <th>Paid Amount</th>
                                <th>Paid By</th>
                                <th>Date</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($invoice->payments as $payment)
                                <tr>
                                    <td>{{$payment->tr_code}}</td>
                                    <td>{{number_format($payment->amount)}}</td>
                                    <td>{{$payment->user->name}}</td>
                                    <td>{{$payment->created_at->format('d-m-Y')}}</td>
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

      
    </script>
    @endpush
