<div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title text-uppercase" id="myModalLabel">@lang('main.update_profile')</h4>
        </div>     
        <div class="modal-body grid simple horizontal purple">              
            <div class="grid-body">
                <div class="row">
                    <form method="post" id="edit-person">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">@lang('main.name')</label>
                                <input type="text" class="form-control" name="name" value="{{$person->name}}" placeholder="@lang('main.contact_name')">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="email">@lang('main.email')</label>
                                <input type="email" class="form-control col-md-6" name="email" placeholder="@lang('main.example_email')" value="{{$person->email}}">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="phone">@lang('main.phone')</label>
                                <input type="text" class="form-control" name="phone_number" id="phone" placeholder="@lang('main.primary_phone')" value="{{$person->phone_number}}">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">@lang('main.address')</label>
                                <input type="text" class="form-control" name="address" placeholder="@lang('main.full_address')" value="{{$person->address}}">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group col-m5-12">
                            <button  type="submit" class="btn btn-success pull-right">
                                <i class="fa fa-pencil"></i> 
                                &nbsp; @lang('main.update') 
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>                                     
<script type="text/javascript">
    let person = {!!json_encode($person)!!};
    $('#edit-person').on('submit', function(event) {
        event.preventDefault();
        let $button = $(this).find('button[type=submit]');
        $button.prop('disabled', true);
        $('.form-group').removeClass('has-error');
        $('.help-block').text('');
        axios.patch(route('companies.people.update', person.id), $(this).getFormData())
        .then(function(response) {
            $.fn.notify(response.data.message);
            setTimeout(function() {location.reload(true)}, 4000);
        }).catch(function(error) {
            $button.removeAttr('disabled');
            @include('partials.js-validation-errors')
        });
        
    })
</script>