@extends('layouts.app')
    @section('content')
            @include('pos.partials.invoice')
            <div class="col-md-1 hidden-print">
              <div class="invoice-button-action-set">
                <p>
                  <a target="_blank" href="?print=true" class="btn btn-primary" type="button"><i class="fa fa-print"></i></a>
                </p>
                <p>
                  @can('accept_payments')
                  @if($sale->due > 0)
                  <button data-url="{{ route('sales.invoice.pay', $sale->id) }}" data-toggle="tooltip" title="Accept Payment" class="btn btn-success ajaxModal" type="button"><i class="fa fa-credit-card"></i></button>
                  @endif
                  @endcan
                </p>
              </div>
            </div>
          </div>
    @endsection