@extends('layouts.app')
    @section('side-menu-nav')
      <div class="inner-menu nav-collapse">
          <div id="inner-menu">
            <div class="inner-wrapper">
              <a class="btn btn-block btn-primary" href="send_email.html"><span class="bold">COMPOSE</span></a>
            </div>
            <div class="inner-menu-content">
              <p class="menu-title">
                FOLDER <span class="pull-right"><i class="icon-refresh"></i></span>
              </p>
            </div>
            <ul class="big-items">
              <li class="active">
                <span class="badge badge-important">2</span> <a href="email.html">Inbox</a>
              </li>
              <li>
                <a href="sent.html">Sent</a>
              </li>
              <li>
                <a href="draft.html">Draft</a>
              </li>
              <li>
                <a href="trash.html">Trash</a>
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