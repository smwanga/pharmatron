
      <div class="page-sidebar hidden-print" id="main-menu" >
        <!-- BEGIN MINI-PROFILE -->
        <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
          <div class="user-info-wrapper sm">
            <div class="profile-wrapper sm">
              <img src="{{asset('img/avatar.png')}}" alt="" data-src="{{asset('img/avatar.png')}}" data-src-retina="{{asset('img/avatar.png')}}" width="69" height="69" />
              <div class="availability-bubble online"></div>
            </div>
            <div class="user-info sm">
              <div class="username">{{Auth::user()->name}}</div>
              <div class="status">{{Auth::user()->email}}</div>
            </div>
          </div>
          <!-- END MINI-PROFILE -->
          <!-- BEGIN SIDEBAR MENU -->
          <ul>
            <li class="start active "> <a href="{{ route('home') }}"><i class="material-icons">home</i> <span class="title">@lang('main.dashboard')</span> <span class="selected"></span> </a>
            </li>
            <li class="">
              <a href="{{ route('sales') }}"> <i class="fa fa-shopping-cart"></i> <span class="title">@lang('main.sales')</span></a>
            </li>
            <li class="">
              <a href="javascript:;"> <i class="fa fa-folder-open"></i> <span class="title">@lang('main.stock')</span> <span class=" arrow"></span> </a>
              <ul class="sub-menu">
                  <li><a href="{{ route('stock.add') }}">@lang('main.add_stock')</a></li>
                  <li><a href="{{ route('products.create') }}">@lang('main.create_stock')</a></li>
                  <li><a href="{{ route('stock.index') }}">@lang('main.stock_listing')</a></li>
              </ul>
            </li>
              <li class="">
              <a href="javascript:;"> <i class="fa fa-credit-card"></i> <span class="title">@lang('main.inventory')</span> <span class=" arrow"></span> </a>
              <ul class="sub-menu">
                  <li><a href="{{ route('products.index') }}">@lang('main.products')</a></li>
                  <li><a href="#">@lang('main.expenses')</a></li>
                  <li><a href="{{ route('purchase_order.create') }}">@lang('main.purchase_orders')</a></li>
              </ul>
            </li>
            <li class="">
              <a href="javascript:;"> <i class="fa fa-briefcase"></i> <span class="title">@lang('main.suppliers')</span> <span class=" arrow"></span> </a>
              <ul class="sub-menu">
                  <li><a href="{{ route('suppliers.index') }}">@lang('main.suppliers')</a></li>
                  <li><a href="{{ route('suppliers.create') }}">@lang('main.add_supplier')</a></li>
              </ul>
            </li>
            <li class="">
              <a href="{{ route('users.index') }}"> <i class="material-icons">contacts_child</i> <span class="title">@lang('main.users')</span></a>
            </li>
            <li class="">
              <a href="{{ route('categories.index') }}"> <i class="fa fa-wrench"></i> <span class="title">@lang('main.categories')</span></a>
            </li>
            <li class="">
              <a href="{{ route('settings.index') }}"> <i class="material-icons">settings</i> <span class="title">@lang('main.settings')</span></a>
            </li>
          </ul>
          <div class="clearfix"></div>
          <!-- END SIDEBAR MENU -->
        </div>
        @yield('side-menu-nav')
      </div>
      <a href="#" class="scrollup">Scroll</a>
      <div class="footer-widget">
        <div class="progress transparent progress-small no-radius no-margin">
          <div class="progress-bar progress-bar-success animate-progress-bar" data-percentage="79%" style="width: 79%;"></div>
        </div>
        <div class="pull-right">
          <div class="details-status"> <span class="animate-number" data-value="86" data-animation-duration="560">86</span>% </div>
          <a href="lockscreen.html"><i class="material-icons">power_settings_new</i></a></div>
      </div>