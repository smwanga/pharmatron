@extends('partials.ajax-modal')
    @section('modal-body')
        <div class="grid-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="name">@lang('main.name')</label>
                            <input value="{{$user->name}}" type="text" class="form-control" name="name" id="name" placeholder="Name of person">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="email">@lang('main.email')</label>
                            <input type="email" value="{{$user->email}}" class="form-control col-sm-6" name="email" id="email" placeholder="name@example.com">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="phone">@lang('main.phone')</label>
                            <input type="text" value="{{optional($user->person)->phone_number}}" class="form-control" name="phone_number" id="phone" placeholder="Primary phone number">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="city">@lang('main.city')</label>
                            <input value="{{optional($user->person)->city}}" type="text" class="form-control" name="city" id="city" placeholder="Nairobi">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="address">@lang('main.address')</label>
                            <input type="text" value="{{optional($user->person)->address}}" class="form-control" name="address" id="address" placeholder="Full Address">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="address">@lang('main.user_role')</label>
                            <select class="select2" name="role">
                                <optgroup label="Roles">
                                    <option value="" selected disabled=""> @lang('messages.attach_role') </option>
                                    @foreach($roles as $role)
                                    <option {{Bouncer::is($user)->a($role) ? 'selected': ''}} value="{{$role}}">{{$role}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <button class="btn btn-primary pull-right">
                                <i class="fa fa-pencil"></i> &nbsp; 
                                @lang('main.update_user') 
                            </button>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $('.select2').select2({width:'100%'})
                </script>
@endsection
                       
