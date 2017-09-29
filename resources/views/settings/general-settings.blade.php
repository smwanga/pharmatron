@extends('settings.app-settings')
@section('content')
<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="grid simple horizontal green">
    <div class="grid-title">
        General Settings
    </div>
    <div class="grid-body">
        <form action="{{ route('settings.config.update') }}" class="form-horizontal" style="width: 100%;" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <strong class="col-sm-3 control-label">Site Name</strong>
                <div class="col-sm-9">
                    <input type="text" name="site_name" class="form-control" value="{{$config->site_name}}">
                </div>           
            </div>
             <div class="form-group">
                <strong class="col-sm-3 control-label">Company Address</strong>
                <div class="col-sm-9">
                    <input type="text" name="address" class="form-control" value="{{$config->address}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">Contact Phone</strong>
                <div class="col-sm-9">
                    <input type="text" name="contact_phone" class="form-control" value="{{$config->contact_phone}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">Company E-Mail</strong>
                <div class="col-sm-9">
                    <input type="text" name="contact_email" class="form-control" value="{{$config->contact_email}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">City</strong>
                <div class="col-sm-9">
                    <input type="text" name="city" class="form-control" value="{{$config->city}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">Postal Code</strong>
                <div class="col-sm-9">
                    <input type="text" name="zip_code" class="form-control" value="{{$config->zip_code}}">
                </div>           
            </div>
           {{--  <div class="form-group">
                <strong class="col-sm-3 control-label">Logo</strong>
                <div class="col-sm-9">
                    <img src="{{asset('img/'.$config->app_logo)}}" width="100">
                </div>           
            </div> --}}
            <div class="col-sm-12">
                <button class="btn btn-success pull-right" type="submit"><i class="fa fa-save"></i> &nbsp; @lang('main.save')</button>
            </div>
        </form>
    </div>
</div>
<!-- END PAGE -->
@endsection