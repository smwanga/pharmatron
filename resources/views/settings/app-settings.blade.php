@extends('layouts.app')
    @section('side-menu-nav')
      <div class="inner-menu nav-collapse">
          <div id="inner-menu">
{{--             <div class="inner-wrapper">
              <a class="btn btn-block btn-primary ajaxModal" href="{{ route('settings.config.create') }}"><span class="bold">ADD CONFIG</span></a>
            </div>  --}}
            <div class="inner-menu-content">
            </div>
            <ul class="big-items">
              <li class="{{is_active('settings')}}">
                <a style="width: 100%; display: inline-block;" href="{{ route('settings.index') }}">General Settings</a>
              </li>
              <li class="{{is_active('settings/email-*')}}">
                <a href="{{ route('settings.email') }}">Email Settings</a>
              </li>
              <li>
                <a class="{{ is_active('backups*') }}" href="{{route('backup.list')}}">Backups</a>
              </li>
              <li>
                <a href="{{ route('settings.products') }}">Product Settings</a>
              </li>
              <li class="{{ is_active('settings/access-control*') }}">
                <a href="{{ route('settings.acl.index') }}">@lang('main.access_control')</a>
              </li>
            </ul>
          </div>
        </div>
        @endsection
      @yield('page-content')
@push('scripts')
  <script type="text/javascript">
    $('body').addClass('inner-menu-always-open');
    $('#main-menu').addClass('mini mini-mobile');
  </script>

@endpush