
                @extends('partials.form-wizard')
                    @section('form-body')
                        <div class="tab-pane active fade in" id="tab1">
                            <div class="row m-b-lg">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        General Information
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12 {{error('supplier_id')}}">
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
                                                <div class="form-group col-md-12 {{error('qty')}}">
                                                    <strong for="qty">@lang('main.quantity')</strong>
                                                    <input value="{{old('qty')}}" type="number" class="form-control" name="qty" id="qty" placeholder="Quantity">
                                                    {!! error_msg('qty') !!}
                                                </div>
                                                <div class="form-group col-md-12 {{error('pack_size')}}">
                                                    <strong for="pack_size">@lang('main.pack_size')</strong>
                                                    <input value="{{old('pack_size')}}" type="number" class="form-control" name="pack_size" id="pack-size" placeholder="Pack Size">
                                                    {!! error_msg('pack_size') !!}
                                                </div>
                                                <div class="form-group col-md-12 {{error('pack_size')}}">
                                                    <strong for="alert">@lang('main.total_stock')</strong>
                                                    <input disabled value="{{old('total_stock')}}" type="number" class="form-control" name="total_stock" id="total-stock" placeholder="Total Stock value">
                                                    {!! error_msg('total_stock') !!}
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
                                                <div class="form-group col-md-12 {{error('description')}}">
                                                    <strong for="description">@lang('main.description')</strong>
                                                    <textarea class="form-control" rows="5" name="description" id="description" placeholder="Stock description"></textarea>
                                                    {!! error_msg('description') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Payment Information
                                        </div>
                                        <div class="panel-body">
                                        <div class="col-md-6">
                                            <div class="form-group col-md-12 {{error('ref_number')}}">
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
                                                <div class="form-group  col-md-12 {{error('lpo_number')}}">
                                                    <strong for="lpo_number">@lang('main.lpo_number')</strong>
                                                    <input value="{{old('lpo_number')}}" type="text" class="form-control col-md-6" name="lpo_number" id="stockCode" placeholder="LPO Number">
                                                    {!! error_msg('lpo_number') !!}
                                                </div>
                                                <div class="form-group col-md-12 {{error('supplier_id')}}">
                                                    <strong for="">@lang('main.ref_to_invoice')</strong>
                                                    <div id="el"></div>
                                                    <script type="text/x-template" id="demo-template">
                                                      <div>
                                                        <select2 :options="options" v-model="selected">
                                                          <option disabled value="">No Invoice Referenced</option>
                                                        </select2>
                                                      </div>
                                                    </script>

                                                    <script type="text/x-template" id="select2-template">
                                                      <select name="invoice_id" style="width: 100%;">
                                                        <slot></slot>
                                                      </select>
                                                    </script>
                                                </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group col-md-12 {{error('marked_price')}}">
                                                    <strong for="marked_price">@lang('main.marked_price')</strong>
                                                    <input value="{{old('marked_price')}}"  id="m-price" type="number" class="form-control" name="marked_price" id="marked_price" placeholder="Buying price (Marked Price)">
                                                    {!! error_msg('marked_price') !!}
                                                </div>
                                                <div class="form-group col-md-12 {{error('selling_price')}}">
                                                    <strong for="selling_price">@lang('main.selling_price')</strong>
                                                    <input value="{{old('selling_price')}}"  id="s-price" type="number" class="form-control" name="selling_price" id="selling_price" placeholder="Selling price">
                                                    {!! error_msg('selling_price') !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                 <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-check"></i>  @lang('main.add_stock')</button>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endsection
                    @push('scripts')
                        <script type="text/javascript">
                            var $pack_size = $('#pack-size');
                            var callback = function() {
                                var s_price = $('#m-price').val()/$pack_size.val() *1.33;
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

                            Vue.component('select2', {
                              props: ['options', 'value'],
                              template: '#select2-template',
                              mounted: function () {
                                var vm = this
                                $(this.$el)
                                  // init select2
                                  .select2({ data: this.options, width:'100%'})
                                  .val(this.value)
                                  .trigger('change')
                                  // emit event on change.
                                  .on('change', function () {
                                    vm.$emit('input', this.value)
                                  })
                              },
                              watch: {
                                value: function (value) {
                                  // update value
                                  $(this.$el).val(value).trigger('change');
                                },
                                options: function (options) {
                                  // update options
                                  $(this.$el).select2({ data: options })
                                }
                              },
                              destroyed: function () {
                                $(this.$el).off().select2('destroy')
                              }
                            })

                            var vm = new Vue({
                              el: '#el',
                              template: '#demo-template',
                              data: {
                                options: [
                                  
                                ]
                              },

                              mounted : function () {
                                axios.get('{{ route('invoices.search') }}').then(response => {
                                    this.options = response.data
                                })
                              }
                            });

                        </script>
                    @endpush
                       
