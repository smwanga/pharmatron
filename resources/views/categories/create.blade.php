<div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">@lang('main.create_category')</h4>
        </div>     
        <div class="modal-body grid simple vertical horizontal green">              
            <div class="grid-body no-border">
                <div class="row-fluid">
                <style type="text/css">
                    .select2-search{
                        display:none;
                    }
                </style>
                      <form  action="{{ route('categories.save') }}" method="post">
                            {{csrf_field()}}
                        <div class="form-group">
                            <strong class="control-label col-sm-3">@lang('main.name')</strong>
                                <input type="text" name="category" class="form-control" placeholder="@lang('main.category_name')">
                        </div>
                        <div class="form-group">
                            <strong class="control-label">@lang('main.group')</strong>
                            <select class="select-input" name="group">
                                <optgroup label="@lang('main.categories')">
                                    <option disabled="" value="">Select a Group</option>
                                    <option value="dispense_unit">@lang('main.dispense_unit')</option>
                                    <option value="product">@lang('main.formulation')</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="add-row" class="btn btn-success"><i class="fa fa-check"></i> &nbsp; @lang('main.create')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>                                       
<script type="text/javascript">
    $('.select-input').select2({width:'100%'})
</script> 