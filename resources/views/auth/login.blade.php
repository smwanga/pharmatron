@extends('layouts.auth')

@section('page-content')
    <div class="login-box panel">
        <div class="panel-body">
            <a href="#" class="logo-name text-lg text-center">{{config('app.name')}}</a>
            <p class="text-center m-t-md">@lang('auth.login')</p>
            <form class="m-t-md" action="{{ route('login') }}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <input type="text" value="{{old('email')}}" name="email" class="form-control" placeholder="@lang('main.username')" required>
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="@lang('main.password')" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">@lang('main.login')</button>
                <a href="forgot.html" class="display-block text-center m-t-md text-sm">@lang('auth.forgot')</a>
                
            </form>
            <p class="text-center m-t-xs text-sm">{{date('Y')}} &copy; {{config('app.name')}}.</p>
        </div>
    </div>
@endsection
