
      <div class="page-sidebar hidden-print" id="main-menu" >
        <!-- BEGIN MINI-PROFILE -->
        <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
          <div class="user-info-wrapper sm">
            <div class="profile-wrapper sm">
              <img src="{{asset('img/avatar.png')}}" alt="" data-src="{{asset('img/avatar.png')}}" data-src-retina="{{asset('img/avatar.png')}}" width="69" height="69" />
              <div class="availability-bubble online"></div>
            </div>
            <div class="user-info sm">
              <div class="username" style="font-size: 15px;">{{Auth::user()->name}}</div>
              <div class="status">{{Auth::user()->email}}</div>
            </div>
          </div>
          <!-- END MINI-PROFILE -->
          <!-- BEGIN SIDEBAR MENU -->
          <ul>
            <li class="{{is_active('home')}}"> <a href="{{ route('home') }}"><i class="fa fa-desktop"></i> <span class="title">@lang('main.dashboard')</span></a>
            </li>
            <li class="{{is_active('sales*')}}">
              <a href="{{ route('sales') }}"> <i class="fa fa-shopping-basket"></i> <span class="title">@lang('main.sales')</span></a>
            </li>
            <li class="{{is_active('stock*')}}">
              <a href="javascript:;"> <i class="fa fa-truck"></i> <span class="title">@lang('main.stock')</span> <span class=" arrow"></span> </a>
              <ul class="sub-menu">
                  @can('can_add_stock')
                  <li class="{{is_active('stock/add*')}}"><a href="{{ route('stock.add') }}">@lang('main.add_stock')</a></li>
                  @endcan
                  <li class="{{is_active('stock')}}"><a href="{{ route('stock.index') }}">@lang('main.stock_listing')</a></li>
                  
                  
              </ul>
            </li>
            <li class="{{is_active('products*')}}">
              <a href="javascript:;"> <i class="fa fa-shopping-bag"></i> <span class="title">@lang('main.products')</span> <span class=" arrow"></span> </a>
              <ul class="sub-menu">
                  @can('can_add_stock')
                  <li class="{{is_active('products/create')}}"><a href="{{ route('products.create') }}">@lang('main.add_product')</a></li>
                  @endcan
                  <li class="{{is_active('products')}}"><a href="{{ route('products.index') }}">@lang('main.products')</a></li>
                  <li class="{{is_active('products/import-from-file')}}"><a href="{{ route('products.import.create') }}">@lang('main.import_from_file')</a></li>
                  
              </ul>
            </li>
           {{--  <li><a href="#"><i class="fa fa-usd"></i> <span class="title">@lang('main.expenses')</span></a></li> --}}
            <li class="{{is_active('purchase-orders*')}}">
                <a href="{{ route('purchase_order.index') }}">
                  <i class="fa fa-th-list"></i> 
                  <span class="title">@lang('main.purchase_orders')</span>
                </a>
            </li>
            <li class="{{is_active('suppliers*')}}">
              <a href="javascript:;"> <i class="fa fa-briefcase"></i> <span class="title">@lang('main.suppliers')</span> <span class=" arrow"></span> </a>
              <ul class="sub-menu">
                  <li class="{{is_active('suplliers')}}"><a href="{{ route('suppliers.index') }}">@lang('main.suppliers')</a></li>
                  @can('manage.supplier_profile')
                  <li class="{{is_active('suplliers/create')}}"><a href="{{ route('suppliers.create') }}">@lang('main.add_supplier')</a></li>
                  @endcan
              </ul>
            </li>
            <li class="{{is_active('companies*')}}">
              <a href="javascript:;"> <i class="fa fa-apple"></i> <span class="title">@lang('main.companies')</span> <span class=" arrow"></span> </a>
              <ul class="sub-menu">
                  <li class="{{is_active('companies')}}"><a href="{{ route('companies.index') }}">@lang('main.companies')</a></li>
                  @can('manage.supplier_profile')
                  <li class="{{is_active('companies/create')}}"><a href="{{ route('companies.create') }}">@lang('main.create_company')</a></li>
                  @endcan
              </ul>
            </li>
            @can('users.manage')
            <li class="{{is_active('users*')}}">
              <a href="{{ route('users.index') }}"><i class="glyphicon glyphicon-user"></i><span class="title">@lang('main.users')</span></a>
            </li>
            @endcan
            <li class="{{is_active('categories*')}}">
              <a href="{{ route('categories.index') }}"> <i class="fa fa-wrench"></i> <span class="title">@lang('main.categories')</span></a>
            </li>
            @can('change_system_settings')
            <li class="{{is_active('settings*')}}">
              <a href="{{ route('settings.index') }}"> <i class="fa fa-gear"></i> <span class="title">@lang('main.settings')</span></a>
            </li>
            @endcan
          </ul>
          <div class="clearfix"></div>
          <!-- END SIDEBAR MENU -->
        </div>
        @yield('side-menu-nav')
      </div>
      <a href="#" class="scrollup">Scroll</a>