<div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title text-uppercase" id="myModalLabel">@lang('main.new_ability')</h4>
        </div>     
        <div class="modal-body grid simple vertical horizontal green">              
            <div class="grid-body">
                <div class="row">
                      <form  id="create-config-item" class="form form-horizontal"  style="width: 100% !important;" method="post">
                            {{csrf_field()}}

                        <div class="form-group">
                            <strong class="control-label col-sm-3">@lang('main.ability_name') <span class="text-danger">*</span></strong>
                                <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" placeholder="@lang('main.ability_name')">
                                <span class="help-block"></span>
                                </div>
                        </div>
                        <div class="form-group">
                             <strong class="control-label col-sm-3">@lang('main.title') <span class="text-danger">*</span></strong>
                               <div class="col-sm-8">
                                <input type="text" name="title" class="form-control" placeholder="@lang('main.title')">
                                <span class="help-block"></span>
                                </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-11">
                            <button type="submit" id="add-row" class="btn btn-success pull-right"><i class="fa fa-check"></i> &nbsp; @lang('main.create')</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#create-config-item').on('submit', function(e) {
        let data = $(this).getFormData();
        $('.form-group').removeClass('has-error');
        $('.help-block').text('');
        axios.post(route('abilities.store'), data).then(function (response) {
            $.fn.notify(response.data.message);
            setTimeout(function() {location.reload(true)}, 2500);    
        }).catch(function(error) {
            @include('partials.js-validation-errors')
        });
        e.preventDefault();
    });
</script>                                     