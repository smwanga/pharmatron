@extends('partials.ajax-modal')
    @section('modal-body')
        <div class="grid-body">
            <form id="update-user" method="post">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="name">@lang('main.current_pass')</label>
                            <input type="password" class="form-control" name="current_pass">
                             <span class="help-block"></span>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="phone">@lang('main.new_pass')</label>
                            <input type="password" class="form-control" name="new_password">
                             <span class="help-block"></span>
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="email">@lang('main.new_pass')</label>
                            <input type="password"  class="form-control col-sm-6" name="new_password_confirmation">
                             <span class="help-block"></span>
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
            </form>
        </div>
    <script type="text/javascript">
         $('.select2').select2({width:'100%'});

         $('#update-user').on('submit', function(e) {
            event.preventDefault();
            let $data = $(this).getFormData();
            let $user = {!! json_encode($user) !!}
            $('.form-group').removeClass('has-error');
            $('.help-block').text('');
            axios.patch(route('users.pass_update', $user.id), $data).then(function(response) {
                $.fn.notify('User details has been updated');
                location.reload(true);
            }).catch(function(error) {
                @include('partials.js-validation-errors')
            })
         });
    </script>
@endsection
                       
