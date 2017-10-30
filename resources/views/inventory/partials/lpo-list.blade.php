                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('main.lpo_number')</th>
                                        <th>@lang('main.supplier')</th>
                                        <th>@lang('main.date_created')</th>
                                        <th>@lang('main.delivery_date')</th>
                                        <th>@lang('main.total')</th>
                                        <th>@lang('main.status')</th>
                                        <th>@lang('main.invoiced')</th>
                                        <th>@lang('main.options')</th>                
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $key =>  $order)
                                     <tr>
                                         <td>{{++$key}}</td>
                                         <td>{{$order->reference_no}}</td>
                                         <td>{{$order->supplier->supplier_name}}</td>
                                         <td>{{$order->created_at->format('d-m-Y')}}</td>
                                         <td>{{$order->delivery_date->diffForHumans()}}</td>
                                         <td>{{app_cry()->symbol_left.'. '.number_format($order->lpo_total)}}</td>
                                         <td>{{$order->status}}
                                        <td>
                                          @if(! $order->invoiced)
                                            <label class="label label-danger text-white">No</label></td>
                                          @else
                                            <label class="label label-success text-white">Yes</label>
                                          @endif
                                        <td class="text-center">
                                            <button class="btn btn-white btn-mini" data-toggle="dropdown">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                              <li><a href="{{ route('purchase_order.show', $order->id) }}"> <i class="fa fa-eye"></i> View </a></li>
                                              @if(! $order->invoiced)
                                              @can('create_purchase_orders')
                                              <li><a href="{{ route('purchase_order.add_items', $order->id) }}"> <i class="fa fa-plus"></i> Add Items </a></li>
                                              @endcan
                                                @can('create_purchase_orders')
                                                <li><a href="{{ route('purchase_order.edit', $order->id) }}"><i class="fa fa-pencil"></i> Edit</a></li>
                                                @if($order->received)
                                                <li><a href="{{ route('purchase_order.create_invoice', $order->id) }}"><i class="fa fa-credit-card"></i> Invoice Order</a></li>
                                                @endif
                                                @endcan
                                                @else
                                                <li><a href="{{ route('purchase_order.invoice', $order->id) }}"> <i class="fa fa-ticket"></i> View Invoice</a></li>
                                                @endif
                                            </ul>
                                        </td>
                                     </tr>     
                                    @endforeach
                                </tbody>
                            </table>