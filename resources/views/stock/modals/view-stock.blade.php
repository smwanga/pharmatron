<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <br>
            <i class="fa fa-medkit fa-7x"></i>
            <h4 id="myModalLabel" class="semi-bold">
                {{$stock->product->item_name}}
            </h4>
            <p class="no-margin">
                {{$stock->description}}
            </p>
            <br>
        </div>
        <div class="modal-body grid simple horizontal green ">
            <div class="grid-title">
                <strong class="text-uppercase">@lang('main.stock_code') : {{$stock->ref_number}}</strong>
            </div>
            <div class="grid-body">
                <div class="col-md-12 ">
              <div class="tiles white">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                      <strong class="semi-bold text-uppercase">@lang('main.selling_price')</strong>
                      <h4>{{app_cry()->symbol_left}} <span class="item-count animate-number semi-bold" data-value="{{$stock->selling_price}}" data-animation-duration="700">{{number_format($stock->selling_price, 2)}}</span> </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                      <p class="semi-bold text-uppercase">@lang('main.marked_price')</p>
                      <h4> {{app_cry()->symbol_left}} <span class="item-count animate-number semi-bold" data-value="451" data-animation-duration="700">{{number_format($stock->marked_price)}}</span></h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <p class="semi-bold text-uppercase">@lang('main.available_stock')</p>
                        <h4>
                            <span class="item-count animate-number semi-bold" data-value="{{$stock->stock_available}}" data-animation-duration="700">
                            {{number_format($stock->stock_available)}}
                            </span>
                            <small>{{optional($stock->product)->dispensing_unit}}</small>
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                <hr>
                </div>
                <div class="row table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>@lang('main.expiry_date')</th>
                      <th>@lang('main.supplier')</th>
                      <th>@lang('main.lpo_number')</th>
                      <th>@lang('main.pack_size')</th>
                      <th>@lang('main.qty')</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="v-align-middle semi-bold">{{$stock->expiry}}</td>
                      <td class="v-align-middle"><span class="muted">{{$stock->supplier->supplier_name}}</span> </td>
                      <td><span class="muted semi-bold">{{$stock->lpo_number or 'N/A'}}</span> </td>
                      <td class="v-align-middle">{{$stock->pack_size}}</td>
                      <td class="v-align-middle">{{$stock->qty}}</td>
                    </tr>
                  </tbody>
                </table>
            </div>    
              </div>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                {{trans('main.close')}}
            </button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>