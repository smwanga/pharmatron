<div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title text-uppercase" id="myModalLabel">@lang('main.create_config_item')</h4>
        </div>     
        <div class="modal-body grid simple vertical horizontal green">              
            <div class="grid-body">
                <div class="row">
                      <form  id="create-config-item" class="form form-horizontal"  style="width: 100% !important;" action="{{ route('settings.config.save') }}" method="post">
                            {{csrf_field()}}

                        <div class="form-group">
                            <strong class="control-label col-sm-3">@lang('main.config_key') <span class="text-danger">*</span></strong>
                                <div class="col-sm-8">
                                <input required="" type="text" name="key" class="form-control" placeholder="@lang('main.config_item')">
                                <span class="help-block"></span>
                                </div>
                        </div>
                        <div class="form-group">
                             <strong class="control-label col-sm-3">@lang('main.value') <span class="text-danger">*</span></strong>
                               <div class="col-sm-8">
                                <input type="text" name="value" class="form-control" placeholder="@lang('main.value')">
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
        var data = {
            key: $('input[name=key]').val(),
            value: $('input[name=value]').val()
        }
        $('.form-group').removeClass('has-error');
        $('.help-block').text('');
        axios.post('{{ route('settings.config.save') }}', data).then(function (response) {
            $.fn.notify(response.data.message);
            $('#modal').modal('hide');
        }).catch(function(error) {
            @include('partials.js-validation-errors')
        });
        e.preventDefault();
    });
</script>                                     