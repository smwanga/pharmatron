@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="widget-item ">
    <div class="tiles green  overflow-hidden full-height" style="max-height:150px">
        <div class="overlayer bottom-right fullwidth">
            <div class="overlayer-wrapper">
                <div class="tiles gradient-black p-l-20 p-r-20 p-b-20 p-t-20">
                    <p class="h2 text-white">{{$user->name}}</p>
                    <div class="clearfix"></div>
                </div>
          </div>
        </div>
        <img src="/assets/img/cover_pic.png" alt="" class="lazy hover-effect-img image-responsive-width"> 
    </div>
    <div class="tiles white ">
        <div class="tiles-body">
            <div class="row">
                <div class="user-profile-pic text-left">
                    <img width="69" height="69" data-src-retina="/img/avatar.png" data-src="/img/avatar.png" src="/img/avatar.png" alt="">
                    <div class="pull-right m-r-20 m-t-35">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-small btn-white">
                                @lang('main.options')
                            </button>
                            <button class="btn btn-small btn-white" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span> 
                            </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a class="ajaxModal" data-url="{{ route('users.edit', $user->id) }}">
                                            <i class="fa fa-pencil"></i>
                                            &nbsp; @lang('main.update_profile')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="ajaxModal" data-url="">
                                            <i class="fa fa-lock"></i>
                                            &nbsp; @lang('main.reset_password')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('users.timeline', $user->id) }}">
                                            <i class="fa fa-messages"></i>
                                            @lang('main.timeline')
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="">
                                            @lang('main.')
                                        </a>
                                    </li>
                                </ul>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-12 no-padding">
                    <div class="tiles white">
                        <div class="row">
                            <div class="sales-graph-heading">
                                <div class="col-md-6 col-lg-3 col-sm-6">
                                    <p class="bold">@lang('main.email')</p>
                                    <h5><span>{{$user->email}}</span></h5>
                                </div>
                                <div class="col-md-6 col-lg-3 col-sm-6">
                                    <p class="bold">@lang('main.phone')</p>
                                    <h5><span>{{optional($user->person)->phone_number}}</span></h5>
                                </div>
                                <div class="col-md-6 col-lg-3 col-sm-6">
                                    <p class="bold">@lang('main.address')</p>
                                    <h5>{{optional($user->person)->address}} </h5>
                                </div>
                                <div class="col-md-6 col-lg-3 col-sm-6">
                                    <p class="bold">@lang('main.user_role')</p>
                                    <h5>{{optional($user->roles->first())->name ?: 'N/A'}}</h5>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @yield('profile-content')
    </div>
</div>
</div>
@endsection