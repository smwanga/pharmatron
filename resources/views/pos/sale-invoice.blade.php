@extends('layouts.app')
    @section('content')
            @include('pos.partials.invoice')
            <div class="col-md-2 hidden-print">
              <div class="invoice-button-action-set">
                <p>
                  <a target="_blank" onclick="print()" href="#" class="btn btn-white btn-block" type="button"><i class="fa fa-print"></i> Print Invoice
                  </a>
                  <a target="_blank" href="?receipt=true" class="btn m-t-10 btn-white btn-block" type="button"><i class="fa fa-laptop"></i> Print Receipt
                  </a>
                  <a target="_blank" href="{{ route('sales.invoice.labels', $sale->id) }}" class="btn btn-white m-t-10 btn-block" type="button"><i class="fa fa-tag" data-toggle="tooltip" title="Print Lables"></i> Print Labels</a>
                  @can('accept_payments')
                  @if($sale->due > 0 && !$sale->dispensed_at)
                  <button data-url="{{ route('sales.invoice.pay', $sale->id) }}" data-toggle="tooltip" title="Accept Payment" class="btn btn-success ajaxModal btn-block m-t-10" type="button"><i class="fa fa-credit-card"></i>
                    @lang('main.pay_dispense')
                  </button>
                  @endif
                  @if($sale->due > 0 && $sale->dispensed_at)
                  <button data-url="{{ route('sales.invoice.pay', $sale->id) }}" data-toggle="tooltip" title="Accept Payment" class="btn btn-success ajaxModal btn-block m-t-10" type="button"><i class="fa fa-credit-card"></i>
                    @lang('main.pay_cash')
                  </button>
                  @endif
                  @endcan
                  @can('dispense.medicine')
                    @if(!$sale->dispensed_at && $sale->company_id && $sale->due > 0)
                      <form method="post" action="{{ route('sales.invoice.accept_pay', $sale->id) }}">
                        {{csrf_field()}}
                        <button  class="btn btn-primary btn-block m-t-10" type="submit"><i class="fa fa-send"></i>
                        @lang('main.dispense_medicine')
                      </button>
                      </form>
                    @endif
                  @endcan
                  @can('can_update_dispensed_sale')
                    @if($sale->paid === 0)
                      <a href="{{ route('sales.index', $sale->id) }}" class="btn btn-info m-t-10 btn-block"><i class="fa fa-pencil"></i> Edit Invoice</a>
                    @endif
                  @endcan
                </p>
              </div>
            </div>
          </div>
    @endsection