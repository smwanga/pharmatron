@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="widget-item ">
{{--   <div class="controller overlay right">
    <a href="javascript:;" class="reload"></a>
    <a href="javascript:;" class="remove"></a>
  </div> --}}
                        <div class="tiles green  overflow-hidden full-height" style="max-height:150px">
    <div class="overlayer bottom-right fullwidth">
      <div class="overlayer-wrapper">
        <div class="tiles gradient-black p-l-20 p-r-20 p-b-20 p-t-20">
          <p class="h2 text-white">{{$company->company_name}}</p>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <img src="/assets/img/others/great.jpg" alt="" class="lazy hover-effect-img image-responsive-width"> </div>
   <div class="tiles white ">
    <div class="tiles-body">
      <div class="row">
        <div class="user-profile-pic text-left"> <img width="69" height="69" data-src-retina="/img/avatar.png" data-src="/img/avatar.png" src="/img/avatar.png" alt="">
          <div class="pull-right m-r-20 m-t-35">
            <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-small dropdown btn-white btn-demo-space">@lang('main.options')</button>
                        <button class="btn btn-small btn-white dropdown-toggle btn-demo-space" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span> </button>
                        <ul class="dropdown-menu pull-right">
                          @can('can_add_companies')
                          <li><a href="{{ route('companies.edit', $company->id) }}">@lang('main.edit')</a></li>
                          <li><a class="ajaxModal" data-url="{{ route('companies.people.add', $company->id) }}">@lang('main.add_customer')</a></li>
                          @endcan
                          {{-- <li><a href="#">@lang('main.invoices')</a></li> --}}
                          <li class="divider"></li>
                          <li><a href="{{ route('companies.invoice', $company->id) }}">@lang('main.invoices')</a></li>
                        </ul>
                      </div> 
            </div>
        </div>
        <div class="col-md-12 no-padding">
          <div class="tiles white">
              <div class="row">
                  <div class="sales-graph-heading">
                    <div class="col-md-6 col-lg-3 col-sm-6">
                      <p class="bold">Contact Email</p>
                      <h5><span>{{$company->email}}</span></h5>
                    </div>
                    <div class="col-md-6 col-lg-3 col-sm-6">
                      <p class="bold">Contact Phone</p>
                      <h5><span>{{$company->phone_number}}</span></h5>
                    </div>
                    <div class="col-md-6 col-lg-3 col-sm-6">
                      <p class="bold">Website</p>
                      <h5><span><a target="_blank" href="{{$company->website}}">{{$company->website}}</a></span> </h5>
                    </div>
                    <div class="col-md-6 col-lg-3 col-sm-6">
                      <p class="bold">@lang('main.address')</p>
                      <h5>{{$company->address}}</h5>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
                <hr>
                @yield('profile-content')
              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
</div>
@endsection