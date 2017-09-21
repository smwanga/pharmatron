<div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title text-uppercase" id="myModalLabel">@lang('main.edit_lpo_item')</h4>
        </div>     
        <div class="modal-body grid simple vertical horizontal green">              
            <div class="grid-body">
                <div class="row">
                      <form  id="edit-item-form" class="form form-horizontal"  style="width: 100% !important;" action="{{ route('purchase_order.update_item', $item->id) }}" method="post">
                            {{csrf_field()}}
                        <div class="form-group">
                            <strong class="control-label col-sm-3">@lang('main.item_name') <span class="text-danger">*</span></strong>
                                <div class="col-sm-8">
                                <input required="" type="text" value="{{$item->product_name}}" name="product_name" class="form-control" placeholder="@lang('main.product_name')">
                                <span class="help-block"></span>
                                </div>
                        </div>
                        <div class="form-group">
                             <strong class="control-label col-sm-3">@lang('main.qty')</strong>
                               <div class="col-sm-8">
                                <input type="text" value="{{$item->qty}}" name="qty" class="form-control" placeholder="@lang('main.qty')">
                                <span class="help-block"></span>
                                </div>
                        </div>
                        <div class="form-group">
                             <strong class="control-label col-sm-3">@lang('main.price')</strong>
                               <div class="col-sm-8">
                                <input type="text" value="{{$item->unit_cost}}" name="unit_cost" class="form-control" placeholder="@lang('main.price')">
                                <span class="help-block"></span>
                                </div>
                        </div>
                        <div class="form-group">
                             <strong class="control-label col-sm-3">@lang('main.pack_size')</strong>
                               <div class="col-sm-8">
                                <input type="text" value="{{$item->pack_size}}" name="pack_size" class="form-control" placeholder="@lang('main.pack_size')">
                                <span class="help-block"></span>
                                </div>
                        </div>
                        <div class="form-group">
                             <strong class="control-label col-sm-3">@lang('main.notes')</strong>
                               <div class="col-sm-8">
                                <textarea class="form-control" name="notes">{{$item->notes}}</textarea>
                                <span class="help-block"></span>
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-11">
                            <button type="submit" id="edit-btn" class="btn btn-success pull-right"><i class="fa fa-check"></i> &nbsp; @lang('main.update')</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>                                     
<script type="text/javascript">
        var $form = $('#edit-item-form');
        if(typeof $form !== 'undefined'){
            $form.on('submit', function(e) {
            e.preventDefault();
            $form.find('button[type=submit]').prop('disabled', true)
            var data = $form.getFormData();
            axios.post($form.attr('action'), data).then(function(response) {
                $.fn.notify();
                setTimeout(function() {location.reload(true);}, 5000);
                
            }).catch(function(error) {
                $form.find('button[type=submit]').removeAttr('disabled');
                 @include('partials.js-validation-errors');
            });            
          });
        }

</script>