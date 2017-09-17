@extends('layouts.app')
    @section('side-menu-nav')
      <div class="inner-menu nav-collapse">
          <div id="inner-menu">
            <div class="inner-wrapper">
              <a class="btn btn-block btn-primary ajaxModal" href="{{ route('settings.config.create') }}"><span class="bold">ADD CONFIG</span></a>
            </div>
            <div class="inner-menu-content">
              <p class="menu-title">
                FOLDER <span class="pull-right"><i class="icon-refresh"></i></span>
              </p>
            </div>
            <ul class="big-items">
              <li class="active">
                <a style="width: 100%; display: inline-block;" href="email.html">General Settings</a>
              </li>
              <li>
                <a style="width: 100%; display: inline-block;" href="sent.html">Email Settings</a>
              </li>
              <li>
                <a style="width: 100%; display: inline-block;" href="draft.html">Invoice Settings</a>
              </li>
              <li>
                <a style="width: 100%; display: inline-block;" href="trash.html">Product Settings</a>
              </li>
            </ul>
          </div>
        </div>
        @endsection
        @section('content')
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="grid simple horizontal green">
          <div class="grid-title">
            App Settings
          </div>
          <div class="grid-body">
            <div class="form-group">
              <strong>Site Name</strong>
              <input type="text" name="app_name" class="form-control">
            </div>
          </div>
        </div>
        <!-- END PAGE -->
@endsection
@push('scripts')
  <script type="text/javascript">
    $('body').addClass('inner-menu-always-open');
    $('#main-menu').addClass('mini mini-mobile');
  </script>

@endpush