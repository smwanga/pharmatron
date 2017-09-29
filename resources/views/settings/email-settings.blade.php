@extends('settings.app-settings')
@section('content')
<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="grid simple horizontal green">
    <div class="grid-title">
        Email Settings
    </div>
    <div class="grid-body">
        <form action="{{ route('settings.config.update') }}" class="form-horizontal" style="width: 100%;" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <strong class="col-sm-3 control-label">SMTP HOST</strong>
                <div class="col-sm-9">
                    <input type="text" name="smtp_host" class="form-control" value="{{$config->smtp_host}}">
                </div>           
            </div>
             <div class="form-group">
                <strong class="col-sm-3 control-label">SMTP Username</strong>
                <div class="col-sm-9">
                    <input type="text" name="smtp_username" class="form-control" value="{{$config->smtp_username}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">SMTP Password</strong>
                <div class="col-sm-9">
                    <input type="text" name="smtp_password" class="form-control" value="{{$config->smtp_password}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">SMTP Port</strong>
                <div class="col-sm-9">
                    <input type="text" name="smtp_port" class="form-control" value="{{$config->smtp_port}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">Sparkpost</strong>
                <div class="col-sm-9">
                    <input type="text" name="sparkpost_domain" class="form-control" value="{{$config->sparkpost_domain}}">
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