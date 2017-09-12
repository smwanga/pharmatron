
                @extends('partials.form-wizard')
                    @section('form-body')
                        <div class="tab-pane active fade in" id="tab1">
                            <div class="row m-b-lg">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="row">
                                        @include('components.errors')
                                        <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="name">@lang('main.name')</label>
                                            <input value="{{old('name')}}" type="text" class="form-control" name="name" id="name" placeholder="Name of person">
                                        </div>
                                        <div class="form-group  col-sm-6">
                                            <label for="email">@lang('main.email')</label>
                                            <input type="email" value="{{old('email')}}" class="form-control col-sm-6" name="email" id="email" placeholder="name@example.com">
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="phone">@lang('main.phone')</label>
                                            <input type="text" value="{{old('phone_number')}}" class="form-control" name="phone_number" id="phone" placeholder="Primary phone number">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="city">@lang('main.city')</label>
                                            <input value="{{old('city')}}" type="text" class="form-control" name="city" id="city" placeholder="Nairobi">
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="address">@lang('main.address')</label>
                                            <input type="text" value="{{old('address')}}" class="form-control" name="address" id="address" placeholder="Full Address">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="address">@lang('main.user_role')</label>
                                            <select class="select2" name="role">
                                                <optgroup label="Roles">
                                                    <option value="" selected disabled="">Please Attach a role to a user </option>
                                                    @foreach($roles as $role)
                                                    <option value="{{$role}}">{{$role}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="password">@lang('main.password')</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter A Strong Password">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="password_confirmation">@lang('main.confirm_password')</label>
                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Your password">
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 form-group">
                                                <button class="btn btn-primary pull-right">
                                                    <i class="fa fa-check"></i> &nbsp; 
                                                    @lang('main.create_user') 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endsection
                       
