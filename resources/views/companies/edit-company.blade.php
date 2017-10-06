@extends('layouts.app')
    @section('content')
        <div class="grid horizontal simple green">
            <div class="grid-title"><h4>{{$pagetitle}}</h4></div>
                <div class="grid-body">
                    <div class="row m-b-lg">
                        <form method="post" action="{{ route('companies.update', $company->id) }}">
                            {{csrf_field()}} {{method_field('patch')}}
                            <input type="hidden" name="company_id" value="{{$company->id}}">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="row">
                                        <div class="form-group col-md-6 {{error('company_name')}}">
                                            <label for="name">@lang('main.company_name')</label>
                                            <input value="{{old('company_name', $company->company_name)}}" type="text" class="form-control" name="company_name" id="name" placeholder="@lang('main.company_name')">
                                            {!! error_msg('company_name') !!}
                                        </div>
                                        <div class="form-group  col-md-6 {{error('email')}}">
                                            <label for="stockCode">@lang('main.email')</label>
                                            <input type="email" value="{{old('email', $company->email)}}" class="form-control col-md-6" name="email" id="email" placeholder="@lang('main.example_email')">
                                             {!! error_msg('email') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 {{error('phone_number')}}">
                                            <label for="phone">@lang('main.phone')</label>
                                            <input type="text" value="{{old('phone_number', $company->phone_number)}}" class="form-control" name="phone_number" id="phone" placeholder="Primary phone number">
                                             {!! error_msg('phone_number') !!}
                                        </div>
                                        <div class="form-group col-md-6 {{error('website')}}">
                                            <label for="website">@lang('main.website')</label>
                                            <input value="{{old('website', $company->website)}}" type="text" class="form-control" name="website" id="website" placeholder="@lang('main.example_site')">
                                             {!! error_msg('website') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 {{error('address')}}">
                                            <label for="address">@lang('main.address')</label>
                                            <input type="text" value="{{old('address', $company->address)}}" class="form-control" name="address" id="address" placeholder="Full Address or Postal Address">
                                             {!! error_msg('address') !!}
                                        </div>
                                        <div class="form-group col-md-6 {{error('city')}}">
                                            <label for="city">@lang('main.city')</label>
                                            <input value="{{old('website', $company->city)}}" type="text" class="form-control" name="city" id="city" placeholder="@lang('main.city')">
                                             {!! error_msg('city') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 {{error('notes')}}">
                                            <label for="alert">@lang('main.notes')</label>
                                            <textarea class="form-control" name="notes" rows="4" >{{old('notes')}}</textarea>
                                             {!! error_msg('notes', $company->notes) !!}
                                        </div>
                                        <div class="form-group col-m5-12">
                                            <button class="btn btn-primary pull-right"><i class="fa fa-check"></i> &nbsp; @lang('main.save') </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
@endsection
                       
