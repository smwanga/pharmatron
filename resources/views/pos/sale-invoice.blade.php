@extends('layouts.app')
    @section('content')
            @include('pos.partials.invoice')
            <div class="col-md-2 hidden-print">
              <div class="invoice-button-action-set">
                <p>
                  <a target="_blank" href="?print=true" class="btn btn-primary m-b-10" type="button"><i class="fa fa-print"></i> Print Invoice
                  </a>
                  <a target="_blank" href="{{ route('sales.invoice.labels', $sale->id) }}" class="btn btn-white m-b-10" type="button"><i class="fa fa-tag" data-toggle="tooltip" title="Print Lables"></i> Print Labels</a>
                </p>
                <p>
                  @can('accept_payments')
                  @if($sale->due > 0)
                  <button data-url="{{ route('sales.invoice.pay', $sale->id) }}" data-toggle="tooltip" title="Accept Payment" class="btn btn-success ajaxModal" type="button"><i class="fa fa-credit-card"></i>
                    Accept Payment
                  </button>
                  @endif
                  @endcan
                </p>
              </div>
            </div>
          </div>
    @endsection