@extends('layouts.app')
    @section('content')
        <div class="grid simple vertical green">
            <div class="tiles white add-margin">
                <div class="p-t-20 p-l-20 p-r-20 p-b-20">
                    <div class="row b-grey b-b">
                        <div class="col-md-4 col-sm-4">
                            <h4 class="text-black semi-bold">@lang('main.total_amount')</h4>
                            <h3 class="text-success semi-bold">KES <span class="gross" id="gross" >{{$sale ? number_format($sale->total, 2) : 0}}</span></h3>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="m-t-20">
                                <h5 class="text-black semi-bold">@lang('main.items')</h5>
                                <h4 id="itemm-count" class="text-info semi-bold">{{count($items)}}</h4>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="m-t-20 form-group">
                                 <div class="input-group">
                                        <input id="item-search" type="text" class="pull-right form-control">
                                          <span  style="cursor: pointer; color:#fff !important;" class="input-group-addon primary">
                                            <span class="arrow"></span>
                                            <span style="color:#fff !important;"  class="addon" data-toggle="tooltip" title="@lang('main.search')"><i class="fa fa-search"></i></span>
                                          </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row b-grey table-responsive">
                        <table class="table table-condensed">
                           <thead>
                               <tr>
                                   <th>#</th>
                                   <th style="width:25%">@lang('main.item_name')</th>
                                   <th style="width:10%">@lang('main.qty')</th>
                                   <th style="width:10%">@lang('main.price')</th>
                                   <th style="width:10%">@lang('main.total')</th>
                                   <th style="width:35%">@lang('main.instructions')</th>
                                   <th></th>
                               </tr>
                           </thead> 
                           <tbody>
                               @foreach($items as $key => $item)
                               <tr>
                                  <form action="{{ route('sales.item.update', $item->id) }}" method="post">
                                    <td>{{++$key}}</td>
                                    <td>{{$item->product->generic_name}}</td>
                                    <td><input type="number" name="qty" class="item-qty form-control" value="{{$item->qty}}" data-max="{{$item->product->available_stock}}"></td>
                                    <td><input type="number" step="0.01" name="unit_cost" class="unit-cost form-control" value="{{$item->unit_cost}}"></td>
                                    <td class="total">{{number_format($item->qty * $item->unit_cost, 2)}}</td>
                                    <td><textarea class="instructions form-control" name="instructions">{{$item->instructions}}</textarea></td>
                                    <td><a  data-toggle="tooltip" title="@lang('main.remove_item')" href="{{ route('sales.item.delete', $item->id) }}" class="btn btn-small btn-danger remove-item"> <i class="fa fa-trash"></i></a></td>
                                  </form>
                               </tr>
                               @endforeach

                           </tbody>
                        </table>
                        @if(count($items) >  0 && isset($sale))
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="13%"><strong>@lang('main.customer_name')</strong></td>
                                    <td width="22%" class="form-group">
                                      <div class="input-group">
                                        <input id="customer-name" type="text" value="{{$sale->customer_name}}" class="sale-invoice pull-right form-control">
                                          <span data-url="{{ route('customers.create') }}" style="cursor: pointer; color:#fff !important;" class="input-group-addon primary ajaxModal">
                                            <span class="arrow"></span>
                                            <span style="color:#fff !important;"  class="addon" data-toggle="tooltip" title="@lang('main.add_customer')"><i class="fa fa-plus"></i></span>
                                          </span>
                                        </div>
                                      </td>
                                    <td width="18%"><strong class="pull-right">@lang('main.discount_pct')</strong></td>
                                    <td width="17%"><input id="discount" value="{{$sale->discount?:0}}" type="number" step="0.01" class="sale-invoice pull-right form-control"></td>
                                    <td width="20%"><strong>@lang('main.sub_total'): Ksh. <span class="gross">{{$sale ? number_format($sale->total, 2) : 0}}</span> </strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2" width="30%"></td>
                                    <td width="18%"><strong class="pull-right">@lang('main.tax_pct')</strong></td>
                                    <td width="17%"><input id="tax" type="number" step="0.01" value="{{$sale->tax?:0}}" class="sale-invoice pull-right form-control"></td>
                                    <td width="20%"><strong>@lang('main.grand_total'): Ksh. <span id="grand-total"> {{$sale ? number_format($sale->total, 2) : 0}}</span></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4" width="80%"></td>
                                    <td width="20%"><button id="dispense-drugs" class="btn btn-primary btn-block">@lang('main.save_prescription')</button></td>
                                </tr>
                            </tbody>
                        </table>
                      @endif
                    </div>
                </div>
                <div class="tiles white" id="sales_chart_alt" style="height: 260px; width: 100%; padding: 0px;">

                </div>
                
            </div>
        </div>
    @endsection
    @push('scripts')
    <script type="text/javascript">
        $('#item-search').autocomplete({
            serviceUrl:'{{ route('sales.search') }}',
            onSelect: function (result) {
                @isset($sale)
                    var url = '{{ route('sales.item.add',$sale->id) }}';
                @else
                    var url = '{{ route('sales.item.add') }}';
                @endisset
                var data = {product: result.data};
                axios.post(url, data).then(function(response) {                
                    window.location.href = route('sales.index', response.data.id);
                }).catch(error => {
                    console.log(error.response);
                });
            }
        });
        $(document).ready(function() {
            $('#search').easyAutocomplete({
                url: function(param) {
                  return route('sales.search')+'?query='+param;
                },
                listLocation: "suggestions",
                getValue: "value"
            });
        });
        
       $('.item-qty').on('change keyup', function(e) {
          var total = $(e.target).closest('tr').find('.total');
          var cost = $(e.target).closest('tr').find('.unit-cost');
          tot = cost.val() * $(e.target).val();
          total.text(parse_float(tot));     
        });
       $('.unit-cost').on('change keyup', function(e) {
          var total = $(e.target).closest('tr').find('.total');
          var qty = $(e.target).closest('tr').find('.item-qty');
          tot = qty.val() * $(e.target).val();
          total.text(tot);
        });
       $('.item-qty').on('change', function(e) {
        var $el = $(this), $val = $el.val();
          if($el.data('max') < $val) {
             $el.parent('td').addClass('form-group has-error');
             notify('The selected quantity is is above the available stock of '+$el.data('max'), 'Opps', 'error' );
             return false;
          }
          $el.parent('td').removeClass('form-group has-error');
          var $form = $(e.target).closest('tr').find('form');
          axios.post($form.attr('action'), {qty:  $val}).then(function(response) {
            update();
          });
        });
       $('.unit-cost').on('change', function(e) {
          var $form = $(e.target).closest('tr').find('form');
          axios.post($form.attr('action'), {unit_cost:  $(e.target).val()}).then(function(response) {
            update();
          });       
        });
       $('.instructions').on('change', function(e) {      
          var $form = $(e.target).closest('tr').find('form');
          axios.post($form.attr('action'), {instructions:  $(e.target).val()});         
        });
       $('.remove-item').on('click', function(e) {
        if(confirm('Are you sure you want to remove this item')) {
          axios.delete($(this).attr('href')).then(function(response) {
            $(e.target).closest('tr').remove();
            notify('The item was successfully removed');
            update();
          });
        }
        e.preventDefault()
       });
       $('#discount').on('change keyup', function(e) {
          calculateTaxAndDiscount($(this), 'Discount');
       })
       @isset($sale)
       var salesUrl = '{{ route('sales.update', $sale->id) }}';
        $('.sale-invoice').on('change', function(e) {
            axios.post(salesUrl, {discount:$('#discount').val(), tax: $('#tax').val(), customer_name:$('#customer-name').val()}).catch(function(response) {
                notify('An error was encountered while syncronizing the sale', 'Whoops! Something is broken', 'error');
            });
       });
        $('#customer-name').autocomplete({
            serviceUrl:'{{ route('customers.search') }}',
            onSelect: function (result) {
                $(this).val(result.data.name);
                axios.post(salesUrl, {customer_name:result.data.name, customer_id:result.data.id});
            }
        });
        $('#dispense-drugs').on('click', function(e) {
            axios.post(salesUrl, {type:'invoice'}).then(function(response) {
                window.location.href= '{{ route('sales.invoice', $sale->id) }}'
            })
        });
        @endisset
        $('#tax').on('change keyup', function(e) {
          calculateTaxAndDiscount($(this), 'Tax');
       })

       function update() {
         var total = 0;
         $('.total').each(function(i) {
            var gross = $('.gross');
            total += parseFloat($(this).text().replace(/,/g, ''));
            gross.animateNumbers(total);
            $('#itemm-count').animateNumbers(++i);
         })       
       }
       function notify(message = 'The operation was successful', title = 'Success', type = 'success') {
          new PNotify({
                title: title,
                text: message,
                type: type,
                styling: 'fontawesome'
            });
        }
        function calculateTaxAndDiscount($el, type) {
          var $el_tax = $('#tax').val(),
          $el_discount = $('#discount').val(),
          $discount = parse_float($el_discount ? $el_discount : 0),
          $tax = parse_float($el_tax ? $el_tax : 0);
          //
          if(($discount > 100 || $tax > 100) || ($discount < 0 || $tax < 0)) {
            notify('The '+type+' is way too much beyond normal', 'Watch out here', 'warning');
            $el.parent('td').addClass('form-group has-error');
          } else {
            // Remove error class
            $el.parent('td').removeClass('form-group has-error');
            // Variable initialization and declaration
            var gross = parse_float($('#gross').text()),
            tax = parse_float(($tax/100) + 1),
            discount = parse_float((100 - $discount) / 100),
            sub_total = parse_float(gross * tax),
            grand_total = parse_float(sub_total * discount);
            // For debuging purposes only
            console.log('Tax -> '+tax+', Discount -> '+discount+', Gross -> '+gross+', Grand Total -> '+grand_total+', Sub Total -> '+sub_total);
            // Set the grand total
            $('#grand-total').animateNumbers(grand_total);
          }
        }

        function parse_float(value) {
          return parseFloat(String(value).replace(/,/g, '')).toFixed(2);
        }      
    </script>
    @endpush
