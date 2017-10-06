@extends('companies.company-profile')

@section('profile-content')
<div class="row-fluid">
    <div class="grid simple horizontal green">
        <div class="grid-title">
            <strong>@lang('main.invoices')</strong>
        </div>
        <div class="grid-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>@lang('main.ref_no')</th>
                        <th>@lang('main.patient')</th>
                        <th>@lang('main.paid_amount')</th>
                        <th>@lang('main.due_amount')</th>
                        <th>@lang('main.total')</th>
                        <th>@lang('main.date_created')</th>
                        <th>@lang('main.options')</th>                
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $key =>  $sale)
                     <tr>
                        <td>{{$sale->ref_number}}</td>
                        <td>{{$sale->customer_name}}</td>
                        <td>{{number_format($sale->paid, 2)}}</td>
                        <td>{{number_format($sale->due,2)}}</td>
                        <td>{{number_format($sale->total, 2) }}</td>
                        <td>{{$sale->created_at->format('Y-m-d')}}</td>
                        <td class="text-center">
                            <button class="btn btn-white btn-mini" data-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ route('sales.invoice', $sale->id) }}">@lang('main.view')</a></li>
                            </ul>
                        </td>
                     </tr>     
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection