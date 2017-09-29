@extends('users.user-profile')
@section('profile-content')

    <div class="col-sm-12">
        <div class="tiles white">
            <hr>
            <div class="row">
                <h4><strong class="m-l-40">User Sales</strong></h4>
                <div class="sales-graph-heading">
                    <div class="col-md-5 col-sm-5">
                        <h5 class="no-margin">This Year</h5>
                        <h4>
                            <span class="item-count animate-number semi-bold" data-value="{{$sales['this_year']}}" data-animation-duration="700">{{$sales['this_year']}}</span> {{app_cry()->symbol_left}}
                        </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <p class="semi-bold">TODAY</p>
                        <h4>
                            <span class="item-count animate-number semi-bold" data-value="{{$sales['today']}}" data-animation-duration="700">{{$sales['today']}}</span> {{app_cry()->symbol_left}}
                        </h4>
                    </div>
                    <div class="col-md-4 col-sm-3">
                        <p class="semi-bold">THIS MONTH</p>
                        <h4>
                            <span class="item-count animate-number semi-bold" data-value="{{$sales['this_month']}}" data-animation-duration="700">{{$sales['this_month']}}</span> {{app_cry()->symbol_left}}
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="row white">
                <div class="m-l-20 m-r-20 ">
                  <table class="table no-more-tables">
                    <thead>
                      <tr class="">
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Ref Number</th>
                        <th>Total</th>
                        <td>Date</td>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($mauzo = $user->sales()->whereType('invoice')->orderBy('created_at', 'DESC')->take(30)->paginate(5) as $key => $sale)
                      <tr class="">
                        <td class="v-align-middle">
                          {{++$key}}
                        </td>
                        <td class="v-align-middle">{{$sale->customer_name}}</td>
                        <td class="v-align-middle"><span class="muted">{{$sale->ref_number}}</span>
                        </td>
                        <td><span class="muted">{{number_format($sale->total, 2) }}</span>
                        </td>
                        <td>{{$sale->created_at->diffForHumans()}}</td>
                        <td class="text-right">
                          <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-small dropdown btn-white btn-demo-space"><i class="fa fa-cog"></i> @lang('main.options')</button>
                              <ul class="dropdown-menu pull-right">
                                @if($sale->type == 'invoice')
                                <li><a href="{{ route('sales.invoice', $sale->id) }}">@lang('main.view')</a></li>
                                @endif
                                @if($sale->type == 'draft')
                                <li><a href="{{ route('sales.index', $sale->id) }}">@lang('main.view')</a></li>
                                @endif
                                @can('delete_sales_records')
                                <li><a href="#">@lang('main.delete')</a></li>
                                @endcan
                                <li class="divider"></li>
                                <li><a href="{{ route('sales.invoice.labels', $sale->id) }}">@lang('main.view_labels')</a></li>
                              </ul>
                            </div> 
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <div class="text-center">
                      {!! $mauzo->render() !!}
                  </div>
                </div>
                <div class="col-md-8">
                    <div id="sales-graph">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection