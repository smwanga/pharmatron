@extends('layouts.master')
    @section('content')
    <div class="col-md-12">
        <div class="grid simple">
            <div class="grid-body no-border invoice-body">
                <div class="row">
                    <div class="col-xs-8">
                        <div class="col-xs-3">
                            <img src="{{asset('img/'.app_config('app_logo'))}}" width="100" height="100" class="invoice-logo" alt="">
                        </div>
                        <div class="col-xs-9">
                            @include('partials.company-address')
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <h3 class="pull-right">@lang('main.report')</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    @yield('pdf-content')            
                </div>
            </div>
        </div>
    </div>
    @endsection