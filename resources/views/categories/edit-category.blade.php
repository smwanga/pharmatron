<div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">@lang('main.update_category')</h4>
        </div>     
        <div class="modal-body grid simple vertical horizontal green">              
            <div class="grid-body no-border">
                <div class="row-fluid">
                      <form  action="{{ route('categories.update', $category->id) }}" method="post">
                            {{csrf_field()}}
                            {{method_field('patch')}}
                        <div class="form-group">
                            <strong class="control-label col-sm-3">@lang('main.category_name')</strong>
                                <input value="{{$category->category}}" type="text" name="category" class="form-control" placeholder="@lang('main.category_name')">
                        </div>
                        <div class="form-group">
                            <strong class="control-label">@lang('main.group')</strong>
                            <select class="form-control" name="group">
                                <optgroup label="@lang('main.categories')">
                                    <option></option>
                                    <option {{$category->group== 'dispense_unit' ? 'selected' : ''}} value="dispense_unit">@lang('main.dispense_unit')</option>
                                    <option {{$category->group== 'product' ? 'selected' : ''}} value="product">@lang('main.product')</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <strong class="control-label">@lang('main.description')</strong>
                            <textarea class="form-control" rows="4" name="description">{{$category->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-pencil"></i> &nbsp; @lang('main.update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>                                       