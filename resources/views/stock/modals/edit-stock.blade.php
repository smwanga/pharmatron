<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <br>
            <i class="fa fa-medkit fa-7x"></i>
            <h4 id="myModalLabel" class="semi-bold">
                {{$stock->product->generic_name}}
            </h4>
            <p class="no-margin">
                {{$stock->description}}
            </p>
            <br>
        </div>
        <style type="text/css">
            .form-group {
                margin-bottom:  0 !important;
            }
        </style>
        <div class="modal-body">
            <form action="{{ route('stock.update', $stock->id) }}" method="post">
                {{csrf_field()}}
                <div class="row form-row">
                    <div class="col-md-6 form-group">
                        <strong class="control-label">@lang('main.selling_price')</strong>
                        <input name="selling_price" type="text" class="form-control" placeholder="@lang('main.selling_price')" value="{{$stock->selling_price}}">
                        <span class="help-block" style="display: none"></span>
                    </div>
                    <div class="col-md-6 form-group">
                        <strong class="control-label">@lang('main.batch_no')</strong>
                        <input type="text" class="form-control" placeholder="@lang('main.batch_no')" value="{{$stock->batch_no}}">
                        <span class="help-block" style="display: none"></span>
                    </div>
                </div>
                <div class="row form-row">
                    <div class="col-md-6 form-group">
                        <strong class="control-label">@lang('main.expiry_date')</strong>
                        <input type="text" name="expire_at" class="form-control date-picker" value="{{$stock->expiry}}" placeholder="@lang('main.expiry_date')">
                        <span class="help-block" style="display: none"></span>
                    </div>
                    <div class="col-md-6 form-group">
                        <strong class="control-label">@lang('main.lpo_number')</strong>
                        <input type="text" name="lpo_number" value="{{$stock->lpo_number}}" class="form-control" placeholder="@lang('main.lpo_number')">
                        <span class="help-block" style="display: none"></span>
                    </div>
                </div>
                <div class="row form-row">
                    <div class="col-md-12 form-group">
                        <strong class="control-label">@lang('main.description')</strong>
                        <textarea placeholder="@lang('main.stock_description')" class="form-control" name="description" rows="3">{{ $stock->description }}</textarea>
                        <span class="help-block" style="display: none"></span>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                Close
            </button>
            <button id="submit-btn" type="button" class="btn btn-primary">
                Save Changes
            </button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<script type="text/javascript">
    $('#submit-btn').on('click', function(e) {
        let data = {
            lpo_number: $('input[name=lpo_number]').val(),
            selling_price: $('input[name=selling_price]').val(),
            description: $('textarea[name=description]').val(),
            expire_at: $('input[name=expire_at]').val(),
            lpo_number: $('input[name=lpo_number]').val()
        };
        $('.form-group').removeClass('has-error');
        $('.help-block').text('');
        axios.patch('{{ route('stock.update', $stock->id) }}', data).then(function(response) {
            $.fn.notify(response.data.message, response.data.title);
            $('#modal').modal('hide');
        }).catch(function(error) {
            @include('partials.js-validation-errors')
        });
    });
    if($.fn.datepicker) {
        $('.date-picker').datepicker({
            autoclose:true,
            todayHighligt:true,
            format:'yyyy-mm-dd'
        })
    }
</script>
