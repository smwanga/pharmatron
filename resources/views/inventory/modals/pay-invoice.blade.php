<div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title text-uppercase" id="myModalLabel">@lang('main.pay_invoice')</h4>
        </div>     
        <div class="modal-body grid simple vertical horizontal green">              
            <div class="grid-body">
                <div class="row">
                      <form  id="create-config-item" class="form form-horizontal"  style="width: 100% !important;" action="{{ route('purchase_order.invoice.pay', $invoice->id) }}" method="post">
                            {{csrf_field()}}
                        <div class="row b-grey b-b xs-p-b-20">
                            <div class="col-md-4 col-sm-4">
                                <h5 class="text-black semi-bold">Total Invoice Amount</h5>
                                <h4 class="text-success semi-bold">Ksh {{$invoice->total}}</h4>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <h5 class="text-black semi-bold">Total Due</h5>
                                <h4 id="due" class="text-success semi-bold">{{$invoice->due}}</h4>
                            </div>
                            <div class="col-md-5 col-sm-5">
                                <div class="m-t-20">
                                    <input type="number" name="amount" class="dark form-control" id="cash" placeholder="Amount To Pay">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="m-r-20 m-t-20 m-b-10">
                                    <label>Short notes for this Payment</label>
                                    <textarea name="notes" class="form-control" placeholder="@lang('main.notes')">{{app_config('payment_notes')}}</textarea>
                                </div>     
                            </div>
                        </div>
                        <div class="form-group m-t-20">
                            <div class="col-xs-12">
                                <button type="submit" id="add-row" class="btn btn-success pull-right">
                                    <i class="fa fa-credit-card"></i> &nbsp; @lang('main.pay_invoice')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>                                     
<script type="text/javascript">
    $('#cash').on('keyup', function(e) {
        $('#due').animateNumbers({{$invoice->due}} - parseInt($(this).val()));
    })
</script>