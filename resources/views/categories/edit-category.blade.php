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
                <style type="text/css">
                    .select2-search{
                        display:none;
                    }
                </style>
                <div class="row-fluid">
                      <form  action="{{ route('categories.update', $category->id) }}" method="post">
                            {{csrf_field()}}
                            {{method_field('patch')}}
                        <div class="form-group">
                            <strong class="control-label col-sm-3">@lang('main.category_name')</strong>
                                <input value="{{$category->category}}" type="text" name="category" class="form-control" placeholder="@lang('main.category_name')">
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
<script type="text/javascript">
    $('.select-input').select2({width:'100%'})
</script>                                  