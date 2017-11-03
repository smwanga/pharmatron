@extends('settings.app-settings')
@section('content')
<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="grid simple horizontal green">
    <div class="grid-title">
        Product and Invoice Settings
    </div>
    <div class="grid-body">
        <form action="{{ route('settings.config.update') }}" class="form-horizontal" style="width: 100%;" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <strong class="col-sm-3 control-label">Invoice Prefix</strong>
                <div class="col-sm-9">
                    <input type="text" name="inv_prefix" class="form-control" value="{{$config->inv_prefix}}">
                </div>           
            </div>
             <div class="form-group">
                <strong class="col-sm-3 control-label">Purchase Order Prefix</strong>
                <div class="col-sm-9">
                    <input type="text" name="lpo_prefix" class="form-control" value="{{$config->lpo_prefix}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">Payment Notes</strong>
                <div class="col-sm-9">
                    <input type="text" name="payment_notes" class="form-control" value="{{$config->payment_notes}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">Barcode Prefix</strong>
                <div class="col-sm-9">
                    <input type="text" name="barcode_prefix" class="form-control" value="{{$config->barcode_prefix}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">Selleng Price Markup Rate (%)</strong>
                <div class="col-sm-9">
                    <input type="text" name="mark_up_rate" class="form-control" value="{{$config->mark_up_rate}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">Sale Invoice Notes</strong>
                <div class="col-sm-9">
                    <input type="text" name="sale_invoice_notes" class="form-control" value="{{$config->sale_invoice_notes}}">
                </div>           
            </div>

            <div class="col-sm-12">
                <button class="btn btn-success pull-right" type="submit"><i class="fa fa-save"></i> &nbsp; @lang('main.save')</button>
            </div>
        </form>
    </div>
</div>
<!-- END PAGE -->
@endsection