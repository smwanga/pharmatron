@extends('layouts.auth')

@section('page-content')
    <div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
        <h2 class="normal">
          Sign in to {{config('app.name')}}
        </h2>
            <p>
            Please provide your login credentials
            </p>
             @include('components.errors')
          </div>
          <div class="tiles white p-b-20 no-margin text-black tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_login">
              <form class="animated fadeIn validate" action="{{ route('login') }}" method="post">
                {{ csrf_field() }}
                <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                  <div class="col-md-6 col-sm-6">
                    <input value="{{old('email')}}" class="form-control" id="login_username" name="email" placeholder="Email" type="email" required>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" id="login_pass" name="password" placeholder="Password" type="password" required>
                  </div>
                </div>
                <div class="row ">
                  <div class="control-group col-md-10">
                    <div class="m-l-40">
                      <label class="switch sm p-t-20">
                        <input name="remember" type="checkbox" {{old('remember') ? 'checked' : ''}} >
                        <span class="slider"></span>
                      </label>
                       <span class="h5" for="remember">Keep me reminded</span> &nbsp;&nbsp;
                       <a href="{{ route('password.request') }}">Trouble login in?</a>     
                    </div>
                     <button class="btn btn-primary btn-cons pull-right" type="submit"><i class="fa fa-sign-in"></i> &nbsp; Login</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
@endsection
