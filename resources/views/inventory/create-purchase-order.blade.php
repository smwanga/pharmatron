@extends('layouts.app')
@section('content')
<div class="row-fluid">
    <form id="lpo-form" method="post">
        <div class="grid simple horizontal green">
            <div class="grid-title">
                <strong>{{$pagetitle}}</strong>
            </div>
            <div class="grid-body">
                @include('components.errors')
                <div class="form-group col-sm-6 {{error('supplier_id')}}">
                    <label for="">@lang('main.supplier')</label>
                    <select class="select2" name="supplier_id">
                        <optgroup label="@lang('main.suppliers')">
                            @foreach($suppliers as $supplier)
                            <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                            @endforeach
                        </optgroup>
                    </select>
                    <span style="display: none;" class="help-block"></span>
                </div>
                <div class="form-group col-sm-6 {{error('currency_id')}}">
                    <label for="">@lang('main.currency')</label>
                    <select class="select2" name="currency_id">
                        <optgroup label="@lang('main.suppliers')">
                             @foreach($currencies as $currency)
                            <option {{app_config('currency_id') == $currency->id ? 'selected' : ''}} value="{{$currency->id}}">{{$currency->title}}</option>
                            @endforeach
                        </optgroup>
                    </select>
                    <span style="display: none;" class="help-block"></span>
                </div>
                <div class="form-group  col-md-6">
                    <label for="delivery_date">@lang('main.delivery_date')</label>
                    <input type="text" value="{{old('delivery_date')}}" class="form-control date-picker" name="delivery_date" id="delivery_date" placeholder="@lang('main.delivery_date')">
                    <span style="display: none;" class="help-block"></span>
                </div>

                <div class="form-group col-md-6">
                    <label for="alert">@lang('main.notes')</label>
                    <textarea class="form-control" name="notes" rows="4"  placeholder="@lang('messages.lpo_notes')">{{old('notes')}}</textarea>
                    <span style="display: none;" class="help-block"></span>
                </div>
            </div>
        </div>
        <div class="grid simple">
            <div class="grid-title">
                <strong>Delivery Address</strong>
            </div>
            <div class="grid-body">
                <div class="col-sm-12">
                    <div class="form-group col-md-6">
                         <label for="company_name">@lang('main.company_name')</label>
                        <input type="text" value="{{old('supplier_phone', app_config('site_name'))}}" class="form-control" name="name" id="company_name" placeholder="@lang('company_name')">
                        <span style="display: none;" class="help-block"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="street">@lang('main.street')</label>
                        <input value="{{old('street',  app_config('street'))}}" type="text" class="form-control" name="street" id="street" placeholder="@lang('main.street')">
                        <span style="display: none;" class="help-block"></span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group col-md-6">
                        <label for="address_line1">@lang('main.address_line1')</label>
                        <input value="{{old('address_line1',  app_config('address'))}}" type="text" class="form-control" name="address_line1" id="address_line1" placeholder="@lang('main.address_line1')">
                        <span style="display: none;" class="help-block"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="address_line2">@lang('main.address_line2')</label>
                        <input value="{{old('address_line2')}}" type="text" class="form-control" name="address_line2" id="address_line2" placeholder="@lang('main.address_line2')">
                        <span style="display: none;" class="help-block"></span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group col-md-6">
                        <label for="city">@lang('main.city')</label>
                        <input value="{{old('city',  app_config('city'))}}" type="text" class="form-control" name="city" id="city" placeholder="@lang('main.city')">
                        <span style="display: none;" class="help-block"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="zip_code">@lang('main.zip_code')</label>
                        <input value="{{old('zip_code',  app_config('zip_code'))}}" type="text" class="form-control" name="zip_code" id="zip_code" placeholder="@lang('main.zip_code')">
                        <span style="display: none;" class="help-block"></span>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <button class="btn btn-primary pull-right"><i class="fa fa-check"></i> &nbsp; @lang('main.save') </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $('#lpo-form').on('submit', function(event) {
        let data = $(this).getFormData();
        $('.form-group').removeClass('has-error');
        $('.help-block').text('');
        axios.post(route('purchase_order.save'), data).then(function(response) {
            window.location.href = route('purchase_order.add_items', response.data.invoice.id)
        }).catch(function(error) {
             @include('partials.js-validation-errors')
        });
        event.preventDefault();
    })
</script>
@endpush
                       
