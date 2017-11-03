@extends('layouts.app')
    @section('content')
        <div class="grid simple vertical green">
            <div class="tiles white add-margin">
                <div class="p-t-20 p-l-20 p-r-20 p-b-20">
                    <div class="row">
                        <div class="col-sm-8">
                          <div class="col-xs-3">
                            <img src="{{asset('img/'.app_config('app_logo'))}}" width="100" height="100" class="invoice-logo" alt="">
                          </div>
                          <div class="col-xs-9">
                            <address>
                                <strong class="h4">{{app_config('site_name')}}</strong><br>
                                {{app_config('street')}}, {{app_config('address')}}<br>
                                {{app_config('city')}}, {{app_config('zip_code')}}<br>
                                <span><i class="fa fa-phone"></i> :</span> {{app_config('contact_phone')}}, <span><i class="fa fa-envelope-o"></i> : </span> {{app_config('contact_email')}}
                            </address>
                          </div>
                        </div>
                    <div class="col-sm-4">
                        <div class="well well-small green row">
                            <strong>PURCHASE ORDER</strong><br>
                            @lang('main.ref_no') : {{$lpo->reference_no}}<br>
                            @lang('main.delivery_date'): {{optional($lpo->delivery_date)->format('l d M Y')}}<br>
                        </div>
                        
                    </div>
                  </div>
                  <br>
                  <div class="row">
                      <div class="col-sm-8">
                            <h4 class="semi-bold">PREPARED FOR</h4>
                            <address>
                                <strong>{{optional($lpo->supplier)->supplier_name}}</strong><br>
                                {{optional($lpo->supplier)->supplier_address}}<br>
                                {{optional($lpo->supplier)->supplier_email}}<br>
                                <abbr title="Phone">P:</abbr> {{optional($lpo->supplier)->supplier_phone}}
                            </address>
                        </div>
                        <div class="col-sm-4">
                            <h4 class="semi-bold">DELIVERY ADDRESS</h4>
                            <address>
                                <strong>{{optional($lpo->address)->name}}</strong><br>
                                {{optional($lpo->address)->street}}, {{optional($lpo->address)->address_line1}}<br>
                                {{optional($lpo->address)->city}}, {{optional($lpo->address)->zip_code}}<br>
                            </address>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row b-grey">
                        <div class="col-sm-12" id="error-messages">
                          
                        </div>
                        <table id="lpo-table" class="table table-condensed">
                           <thead>
                               <tr>
                                   <th>#</th>
                                   <th style="width: 30%;">@lang('main.item_name')</th>
                                   <th style="width: 10%;">@lang('main.pack_size')</th>
                                   <th style="width: 10%;">@lang('main.qty')</th>
                                   <th style="width: 10%;">@lang('main.price')</th>
                                   <th style="width: 10%;">@lang('main.total')</th>
                                   <th style="width: 20%;">@lang('main.notes')</th>
                                   <th style="width: 10%;">@lang('main.actions')</th>
                               </tr>
                           </thead> 
                           <tbody id="lpo-body">
                            <?php $key = 0; ?>
                               @foreach($items as $item)
                               <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$item->product_name}}</td>
                                    <td>{{$item->pack_size}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>{{$item->unit_cost}}</td>
                                    <td class="total">{{number_format($item->qty * $item->unit_cost, 2)}}</td>
                                    <td><span class="text-muted">{{$item->notes}}</span></td>
                                    <td>
                                        <div class="row">
                                            <a  data-toggle="tooltip" title="@lang('main.edit_item')" data-url="{{ route('purchase_order.edit_item', $item->id) }}" class="btn btn-mini btn-primary ajaxModal btn-demo-space"><i class="fa fa-pencil"></i></a> 
                                            <a data-item="{{$item->id}}" data-toggle="tooltip" title="@lang('main.remove_item')" href="javascript:void()" class="btn btn-mini btn-danger remove-item btn-demo-space"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                       
                               </tr>
                               @endforeach
                               <tr>
                                  <form id="add-lpo-item" method="post">
                                    <input type="hidden" name="product_id">
                                    <td>{{++$key}}</td>
                                    <td><input type="text" name="product_name" class="search form-control"></td>
                                    <td><input type="number" name="pack_size" class="item-pack-size form-control"></td>
                                    <td><input type="number" name="qty" class="item-qty form-control"></td>
                                    <td><input type="number" step="0.01" name="unit_cost" class="unit-cost form-control" ></td>
                                    <td class="total">0</td>
                                    <td><textarea class="instructions form-control" name="notes"></textarea></td>
                                    <td>
                                        <a  data-toggle="tooltip" title="@lang('main.add_item')" href="#" class="btn btn-success btn-block btn-lg" id="add-item"> <i class="fa fa-plus fa-lg"></i> @lang('main.add_item')</a>
                                    </td>
                                  </form>
                               </tr>
                           </tbody>
                        </table>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="70%" class="text-right"><strong>@lang('main.total'): Ksh.</td>
                                    <td width="30%"> <strong id="grand-total"> {{is_numeric($lpo->lpo_total) ? number_format($lpo->lpo_total, 2) : 0}}</strong></td>
                                </tr>
                                <tr>
                                    <td width="70%"></td>
                                    <td width="30%"><button id="save-lpo" class="btn btn-primary btn-block">@lang('main.save')</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tiles white" id="sales_chart_alt" style="height: 260px; width: 100%; padding: 0px;">

                </div>
                
            </div>
        </div>
    @endsection
    @push('scripts')
    <script type="text/javascript">

        var $lpo = {!!json_encode($lpo)!!};
        $('.search').autocomplete({
            serviceUrl:route('sales.search'),
            onSelect: function (result) {
                $(this).val(result.product)
                $('input[name=product_id]').val(result.data)
            }
        });
       $('.item-qty').on('change keyup', function(e) {
            var total = $(e.target).closest('tr').find('.total');
            var cost = $(e.target).closest('tr').find('.unit-cost');
            tot = cost.val() * $(e.target).val();
            total.text(parse_float(tot));
            update();     
        });
       $('.unit-cost').on('change keyup', function(e) {
            var total = $(e.target).closest('tr').find('.total');
            var qty = $(e.target).closest('tr').find('.item-qty');
            tot = qty.val() * $(e.target).val();
            total.text(tot);
            update();
        });
       $('#add-item').on('click', function(event) {
            $errorDiv = $('#error-messages');
            $errorDiv.html('');
            $(event.target).attr('disabled', true);
            $data = $('#add-lpo-item').getFormData();
            axios.post(route('purchase_order.add_item', $lpo.id), $data).then(function(response) {
                $.fn.notify(response.data.message);
                setTimeout(function() {
                     window.location.reload(true);
                 }, 2000);
               
            }).catch(function(error) {
              $(event.target).removeAttr('disabled');
                if(error.response.status == 422){
                    $html = '<div class="row-fluid">'+
                        '<div class="alert alert-error">';
                            $.map(error.response.data, function(el, i) {
                                $html +='<p>'+el[0]+'</p>';
                            });
                        $html + '</div>'+
                        '</div>';
                    $errorDiv.html($html);
                }    
            });
       });
       $('.remove-item').on('click', function(e) {
            e.preventDefault();
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this item!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then(willDelete => {
                    if (willDelete) {

                        axios.delete(route('purchase_order.delete_item', $(this).data('item'))).then( response => {
                            swal("Poof! The item has been deleted!", {
                                icon: "success", 
                            });
                            setTimeout(function() {
                                 window.location.reload(true);
                            }, 2000);
                       });
                  } else {
                        swal("Delete Operation was cancelled"); 
                  }
                });
       });
       $('#save-lpo').on('click', function(event) {
          axios.post(route('purchase_order.save.items', $lpo.id)).then(function(response) {
              location.href = route('purchase_order.show', $lpo.id);
          });
       });
       function update() {
         var total = 0;
         $('.total').each(function(i) {
            var gross = $('#grand-total');
            gross.text('');
            total += parseFloat($(this).text().replace(/,/g, ''));
            gross.animateNumbers(total);
         })       
       }

        function parse_float(value) {
          return parseFloat(String(value).replace(/,/g, '')).toFixed(2);
        }      
    </script>
    @endpush
