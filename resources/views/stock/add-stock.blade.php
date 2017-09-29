
                @extends('layouts.app')
                    @section('content')
                            <div class="m-b-lg">
                                <div class="grid simple hirzontal">
                                    <div class="grid-title">
                                        General Information
                                    </div>
                                    <div class="grid-body">
                                        <form action="{{ route('stock.save', $product->id) }}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group  {{error('supplier_id')}}">
                                                    <strong for="">@lang('main.supplier')</strong>
                                                    <select class="select2" name="supplier_id">
                                                        <optgroup label="@lang('main.suppliers')">
                                                            @foreach($suppliers as $supplier)
                                                            <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                    {!! error_msg('supplier_id') !!}
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 {{error('ref_number')}}">
                                                        <strong for="ref_number">@lang('main.ref_number')</strong>
                                                        <div class="input-group">
                                                            <input value="{{old('ref_number')}}" type="text" class="form-control" name="ref_number" id="ref_number" placeholder="Reference Number">
                                                            <span id="generate-ref" style="cursor: pointer; color:#fff !important;" class="input-group-addon primary">
                                                                <span class="arrow"></span>
                                                                <span style="color:#fff !important;"  class="addon" data-toggle="tooltip" title="Generate Reference Number"><i class="fa fa-coffee"></i></span>
                                                                    </span>
                                                        </div>
                                                        {!! error_msg('ref_number') !!}
                                                    </div>
                                                    <div class="form-group  col-md-6 {{error('lpo_number')}}">
                                                        <strong for="lpo_number">@lang('main.lpo_number')</strong>
                                                        <input value="{{old('lpo_number')}}" type="text" class="form-control col-md-6" name="lpo_number" id="lpo_number" placeholder="LPO Number">
                                                        {!! error_msg('lpo_number') !!}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-4 {{error('qty')}}">
                                                        <strong for="qty">@lang('main.quantity')</strong>
                                                        <input value="{{old('qty')}}" type="number" class="form-control" name="qty" id="qty" placeholder="Quantity">
                                                    {!! error_msg('qty') !!}
                                                    </div>
                                                    <div class="form-group col-md-4 {{error('pack_size')}}">
                                                        <strong for="pack_size">@lang('main.pack_size')</strong>
                                                        <input value="{{old('pack_size')}}" type="number" class="form-control" name="pack_size" id="pack-size" placeholder="Pack Size">
                                                        {!! error_msg('pack_size') !!}
                                                    </div>
                                                    <div class="form-group col-md-4 {{error('total_stock')}}">
                                                        <strong for="alert">@lang('main.total_stock')</strong>
                                                        <input disabled value="{{old('total_stock')}}" type="number" class="form-control" name="total_stock" id="total-stock" placeholder="Total Stock value">
                                                        {!! error_msg('total_stock') !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                
                                                <div class="form-group col-md-12 {{error('expire_at')}}">
                                                    <strong for="expire_at">@lang('main.expiry_date')</strong>
                                                    <input value="{{old('expire_at')}}"  type="text" class="form-control date-picker" name="expire_at" id="expire_at" placeholder="Expiry date">
                                                    {!! error_msg('expire_at') !!}
                                                </div>
                                                <div class="form-group col-md-12 {{error('batch_no')}}">
                                                    <strong for="batch_no">@lang('main.batch_no')</strong>
                                                    <input value="{{old('batch_no')}}"  type="text" class="form-control" name="batch_no" id="batch_no" placeholder="Batch Number">
                                                    {!! error_msg('batch_no') !!}
                                                </div>
                                               <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group col-md-4 {{error('marked_price')}}">
                                                        <strong for="marked_price">
                                                            @lang('main.marked_price')
                                                        </strong>
                                                        <input value="{{old('marked_price')}}"  id="m-price" type="number" class="form-control" name="marked_price" id="marked_price" placeholder="Buying price (Marked Price)">
                                                        {!! error_msg('marked_price') !!}
                                                    </div>
                                                    <div class="form-group col-md-4 {{error('selling_price')}}">
                                                        <strong for="selling_price">
                                                            @lang('main.selling_price')
                                                        </strong>
                                                        <input value="{{old('selling_price')}}"  id="s-price" type="text" class="form-control" name="selling_price" id="selling_price" placeholder="Selling price">
                                                        {!! error_msg('selling_price') !!}
                                                    </div>
                                                    <div class="form-group col-md-4 {{error('discount')}}">
                                                        <strong for="discount">@lang('main.discount') (%)</strong>
                                                        <input value="{{old('discount', 0)}}"  id="s-price" type="text" class="form-control" name="discount" id="discount" placeholder="Apply discount">
                                                        {!! error_msg('discount') !!}
                                                    </div>
                                            </div>
                                               </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-primary pull-right" type="submit">
                                                <i class="fa fa-plus"></i> &nbsp;&nbsp;
                                                @lang('main.add_stock')
                                            </button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                    @endsection
                    @push('scripts')
                        @php
                            $rate = (app_config('mark_up_rate')/100) + 1;
                        @endphp
                        <script type="text/javascript">
                            var $pack_size = $('#pack-size');
                            var callback = function() {
                                var s_price = $('#m-price').val()/$pack_size.val() * {{$rate}};
                                $('#s-price').val(s_price);
                            }

                            var callback2 = function() {
                                var stock = $('#qty').val()*$pack_size.val();
                                $('#total-stock').val(stock);
                            }
                            // Suscribe to input events
                            $('#m-price').on('keyup', callback).on('focus', callback).on('blur', callback);
                            $('#qty').on('keyup', callback2).on('focus', callback2).on('blur', callback2);
                            $pack_size.on('keyup', callback2).on('focus', callback2).on('blur', callback2);

                            $pack_size.on('keyup', callback).on('focus', callback).on('blur', callback);
                            $('#generate-ref').on('click', function() {
                                $('#ref_number').alpha_num(12);
                            })

                            $('#lpo_number').autocomplete({
                                serviceUrl: route('purchase_order.search'),
                                onSelect: function (suggestion) {
                                    $(this).val(suggestion.data)
                                }
                                
                            });
                        </script>
                    @endpush
                       
