@extends('layouts.app')

@section('content')

<div class="row-fluid">
    
    <div class="col-md-12">
        <div class="row 2col">
              <div class="col-md-3 col-sm-6 spacing-bottom-sm spacing-bottom">
                <div class="tiles blue added-margin">
                  <div class="tiles-body">
                    <div class="tiles-title"> TODAY’S SALES </div>
                    <div class="heading">{{app_cry()->symbol_left}} <span class="animate-number" data-value="{{$tiles['sales_today']}}" data-animation-duration="1200">{{number_format($tiles['sales_today'], 1)}}</span></div>
                    <div class="progress transparent progress-small no-radius">
                      <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%" style="width: 100%;"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 spacing-bottom-sm spacing-bottom">
                <div class="tiles green added-margin">
                  <div class="tiles-body">
                    <div class="tiles-title">CURENT STOCK VALUE </div>
                    <div class="heading">{{app_cry()->symbol_left}} <span class="animate-number" data-value="{{$tiles['stock_value']}}" data-animation-duration="1000">{{ number_format($tiles['stock_value']) }}</span> </div>
                    <div class="progress transparent progress-small no-radius">
                      <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="79%" style="width: 79%;"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 spacing-bottom">
                <div class="tiles red added-margin">
                  <div class="tiles-body">
                    <div class="tiles-title"> EXPENSES THIS MONTH </div>
                    <div class="heading">{{app_cry()->symbol_left}} <span class="animate-number" data-value="{{$tiles['expenses']}}" data-animation-duration="1200">{{number_format($tiles['expenses'])}}</span> </div>
                    <div class="progress transparent progress-white progress-small no-radius">
                      <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="45%" style="width: 45%;"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="tiles purple added-margin">
                  <div class="tiles-body">
                    <div class="tiles-title"> SALES THIS MONTH </div>
                    <div class="row-fluid">
                      <div class="heading">{{app_cry()->symbol_left}} <span class="animate-number" data-value="{{$tiles['sales_month']}}" data-animation-duration="700">{{number_format($tiles['sales_month'])}}</span> </div>
                      <div class="progress transparent progress-white progress-small no-radius">
                        <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="12%" style="width: 12%;"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
</div>
<div class="col-md-12">
        <div class="grid horizontal simple green">
            <div class="grid-title"><h4>Recent Sales</h4></div>
            <div class="grid-body">
                <table class="table no-more-tables">
                    <thead>
                      <tr class="">
                        <th style="width:1%">
                          #
                        </th>
                        <th>Customer Name</th>
                        <th>Ref Number</th>
                        <th>Total</th>
                        <th>Created By</th>
                        <th>...</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach(App\Entities\Sale::take(5)->where('type', 'invoice')->orderBy('created_at', 'DESC')->get() as $key => $sale)
                      <tr class="">
                        <td class="v-align-middle">
                          {{++$key}}
                        </td>
                        <td class="v-align-middle">{{$sale->customer_name}}</td>
                        <td class="v-align-middle"><span class="muted">{{$sale->ref_number}}</span>
                        </td>
                        <td><span class="muted">{{number_format($sale->total, 2) }}</span>
                        </td>
                        <td>
                            {{optional($sale->user)->name}}
                        </td>
                        <td>
                            <a href="{{ route('sales.invoice', $sale->id) }}" class="btn btn-small btn-primary">View</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table> 
            </div>
        </div>
    </div>
{{-- <div class="row">
    <div class="col-md-6">
        <div class="grid horizontal simple green">
            <div class="grid-title"><h4>Dashboard</h4></div>
            <div class="grid-body">
                 
            </div>
        </div>
    </div>
    <div class="col-md-6">
       <div class="grid horizontal simple green">
        <div class="grid-title"><h4>Dashboard</h4></div>
                <div class="grid-body">
                 
            </div>
        </div> 
    </div>
</div> --}}
@endsection
