<div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title text-uppercase" id="myModalLabel">@lang('main.add_customer')</h4>
        </div>     
        <div class="modal-body grid simple vertical horizontal green">              
            <div class="grid-body">
                <div class="row">
                    <form method="post" id="add-contact">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">@lang('main.name')</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="@lang('main.contact_name')">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">@lang('main.phone')</label>
                                <input type="text" class="form-control" name="phone_number" id="phone" placeholder="@lang('main.primary_phone')">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group  col-md-6">
                                <label for="email">@lang('main.email')</label>
                                <input type="email" class="form-control col-md-6" name="email" placeholder="@lang('main.example_email')">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">@lang('main.address')</label>
                                <input type="text" class="form-control" name="address" placeholder="@lang('main.full_address')">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group col-m5-12">
                            <button  type="submit" class="btn btn-primary pull-right">
                                <i class="fa fa-check"></i> 
                                &nbsp; @lang('main.save') 
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>                                     
<script type="text/javascript">
    var $company = {!!json_encode($company)!!};
    $('#add-contact').on('submit', function(e) {
        e.preventDefault();
        let $button = $(this).find('button[type=submit]');
        $button.prop('disabled', true);
        $('.form-group').removeClass('has-error');
        $('.help-block').text('');
        axios.post(route('companies.people.save', $company.id), $(this).getFormData())
        .then(function(response) {
            $.fn.notify(response.data.message);
            setTimeout(function() {location.reload(true)}, 4000);
        }).catch(function(error) {
            $button.removeAttr('disabled');
            @include('partials.js-validation-errors')
        });
        
    })
</script>