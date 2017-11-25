<div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title text-uppercase" id="myModalLabel">@lang('main.accept_payment')</h4>
        </div>     
        <div class="modal-body grid simple vertical horizontal green">              
            <div class="grid-body">
                <div class="row">
                      <form  id="create-config-item" class="form form-horizontal"  style="width: 100% !important;" action="{{ route('sales.invoice.accept_pay', $sale->id) }}" method="post">
                            {{csrf_field()}}
                        <div class="row b-grey b-b xs-p-b-20">
                            <div class="col-md-4 col-sm-4">
                                <h5 class="text-black semi-bold">@lang('main.invoice_amount')</h5>
                                <h4 class="text-success semi-bold">{{app_cry()->symbol_left}}. {{$sale->total}}</h4>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <h5 class="text-black semi-bold">@lang('main.invoice_due')</h5>
                                <h4 id="due" class="text-success semi-bold">{{$sale->due}}</h4>
                            </div>
                            <div class="col-md-5 col-sm-5">
                                <div class="m-t-20">
                                    <input type="number" name="cash" class="dark form-control" id="cash" placeholder="Amount Received" min="{{$sale->due}}" step="0.01">
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-t-20">
                            <div class="col-xs-12">
                                <button type="submit" id="add-row" class="btn btn-success pull-right">
                                    <i class="fa fa-credit-card"></i> &nbsp; @lang('main.accept_payment')
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
        var change = parseFloat({{$sale->due}} - parseInt($(this).val())).toFixed(2);
        $('#due').animateNumbers(change);
    })
</script>