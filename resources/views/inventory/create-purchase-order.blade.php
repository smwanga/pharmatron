@extends('layouts.app')
    @section('content')
        <div class="grid simple" id="tab1">
            <div class="grid-body">
                <div class="">
                    <div class="row">
                        @include('components.errors')
                        <div class="form-group col-sm-6 {{error('supplier_id')}}">
                            <strong for="">@lang('main.supplier')</strong>
                            <select class="select2" name="supplier_id">
                                <optgroup label="@lang('main.suppliers')">
                                    @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            {!! error_msg('supplier_id') !!}
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="delivery_date">@lang('main.delivery_date')</label>
                            <input type="text" value="{{old('delivery_date')}}" class="form-control date-picker" name="delivery_date" id="delivery_date" placeholder="@lang('main.delivery_date')">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="alert">@lang('main.notes')</label>
                            <textarea class="form-control" name="notes" rows="4" >
                                {{old('notes')}}
                            </textarea>
                        </div>
                    </div>
                    <div class="grid simple">
                        <div class="grid-title">
                            <strong>Delivery Address</strong>
                        </div>
                        <div class="grid-body">
                            <div class="form-group col-md-6">
                                <label for="company_name">@lang('main.company_name')</label>
                                <input type="text" value="{{old('supplier_phone', app_config('site_name'))}}" class="form-control" name="name" id="company_name" placeholder="@lang('company_name')">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="street">@lang('main.street')</label>
                                <input value="{{old('street')}}" type="text" class="form-control" name="street" id="street" placeholder="@lang('main.street')">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address_line1">@lang('main.address_line1')</label>
                                <input value="{{old('address_line1')}}" type="text" class="form-control" name="address_line1" id="address_line1" placeholder="@lang('main.address_line1')">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address_line2">@lang('main.address_line2')</label>
                                <input value="{{old('address_line2')}}" type="text" class="form-control" name="address_line2" id="address_line2" placeholder="@lang('main.address_line2')">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="city">@lang('main.city')</label>
                                <input value="{{old('city')}}" type="text" class="form-control" name="city" id="city" placeholder="@lang('main.city')">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="zip_code">@lang('main.zip_code')</label>
                                <input value="{{old('zip_code')}}" type="text" class="form-control" name="zip_code" id="zip_code" placeholder="@lang('main.zip_code')">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone_numer">@lang('main.phone')</label>
                                <input value="{{old('phone_numer')}}" type="text" class="form-control" name="phone_numer" id="phone_numer" placeholder="@lang('main.phone')">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone_numer">@lang('main.email')</label>
                                <input value="{{old('email')}}" type="text" class="form-control" name="email" id="email" placeholder="@lang('main.email')">
                            </div>
                            <div class="form-group col-m5-12">
                                <button class="btn btn-primary pull-right"><i class="fa fa-check"></i> &nbsp; @lang('main.save') </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
                       
