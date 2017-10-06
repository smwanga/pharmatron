@extends('layouts.app')
    @section('content')
            @include('pos.partials.invoice')
            <div class="col-md-2 hidden-print">
              <div class="invoice-button-action-set">
                <p>
                  <a target="_blank" href="?print=true" class="btn btn-white btn-block" type="button"><i class="fa fa-print"></i> Print Invoice
                  </a>
                  <a target="_blank" href="?receipt=true" class="btn m-t-10 btn-white btn-block" type="button"><i class="fa fa-laptop"></i> Print Receipt
                  </a>
                  <a target="_blank" href="{{ route('sales.invoice.labels', $sale->id) }}" class="btn btn-white m-t-10 btn-block" type="button"><i class="fa fa-tag" data-toggle="tooltip" title="Print Lables"></i> Print Labels</a>
                  @can('accept_payments')
                  @if($sale->due > 0)
                  <button data-url="{{ route('sales.invoice.pay', $sale->id) }}" data-toggle="tooltip" title="Accept Payment" class="btn btn-success ajaxModal btn-block m-t-10" type="button"><i class="fa fa-credit-card"></i>
                    @lang('main.pay_cash')
                  </button>
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