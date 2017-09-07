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
                      <form  action="{{ route('categories.save') }}" method="post">
                            {{csrf_field()}}
                        <div class="form-group">
                            <strong class="control-label col-sm-3">@lang('main.category_name')</strong>
                                <input type="text" name="category" class="form-control" placeholder="@lang('main.category_name')">
                        </div>
                        <div class="form-group">
                            <strong class="control-label">@lang('main.group')</strong>
                            <select class="form-control" name="group">
                                <optgroup label="@lang('main.categories')">
                                    <option></option>
                                    <option value="dispense_unit">@lang('main.dispense_unit')</option>
                                    <option value="product">@lang('main.product')</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <strong class="control-label">@lang('main.description')</strong>
                            <textarea class="form-control" rows="4" name="description"></textarea>
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