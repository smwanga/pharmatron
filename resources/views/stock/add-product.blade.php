
                @extends('layouts.app')
                    @section('content')
                        <div class="grid simple horizontal green">
                            <div class="grid-title"><h4><strong class="text-uppercase">{{$pagetitle}}</strong></h4></div>
                            <div class="grid-body">
                                <form id="wizardForm" novalidate="novalidate" >
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group  col-md-6">
                                            <label for="item-name">@lang('main.item_name')</label>
                                            <input type="text" class="form-control col-md-6" name="item_name" value="{{old('item_name')}}" id="item-name" placeholder="Item Name">
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="genericName">@lang('main.generic_name')</label>
                                            <input value="{{old('generic_name')}}" type="text" class="form-control" name="generic_name" id="genericName" placeholder="Product name">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group  col-md-6">
                                            <label for="stockCode">@lang('main.product_code')</label>
                                            <input type="text" class="form-control col-md-6" name="stock_code" value="{{old('stock_code')}}" id="stockCode" placeholder="Stock Code">
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="barcode">@lang('main.barcode')</label>
                                            <div class="input-group">
                                            <input value="{{old('barcode')}}" type="number" class="form-control" name="barcode" id="barcode" placeholder="Product's Barcode">
                                            <span id="generate-code" style="cursor: pointer; color:#fff !important;" class="input-group-addon primary">
                                                <span class="arrow"></span>
                                                <span style="color:#fff !important;"  class="addon" data-toggle="tooltip" title="Generate Barcode"><i class="fa fa-barcode"></i></span>
                                                    </span>
                                            </div>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="unit">@lang('main.dispense_unit')</label>
                                            <select class="select2" name="unit">
                                                <optgroup label="@lang('main.dispense_unit')">
                                                    @foreach($dispense_unit as $unit)
                                                    <option value="{{$unit->id}}">{{$unit->category}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                         <div class="form-group col-md-6">
                                            <label for="alert">@lang('main.alert_level')</label>
                                            <input value="{{old('alert_level')}}" type="number" class="form-control" name="alert_level" id="alert" placeholder="Level to alert low stock">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="description">@lang('main.description')</label>
                                            <textarea class="form-control" rows="4" name="description" id="description" placeholder="Product description">{{old('description')}}</textarea>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="instructions">@lang('main.instructions')</label>
                                            <textarea class="form-control" rows="4" name="instructions" id="instructions" placeholder="Usage instructions">{{old('instructions')}}</textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                            <button class="btn btn-primary pull-right" type="submit"><span class="fa fa-check"></span> &nbsp; @lang('main.save')</button>
                                        </div>
                            </div>
                        </form>
                    </div>

                    @endsection
                    @push('scripts')
                    <script type="text/javascript">
                        $('#generate-code').on('click', function() {
                            var tmp = String(Math.floor(Math.random() * (616110999998 - 616110000000 + 1)) + 616110000000);
                            var prefix = '{{app_config('barcode_prefix')}}'.substr(0, 7);
                            tmp = prefix+''+tmp.substr(prefix.length);
                            $('#barcode').barcode(tmp);
                        });
                        $('#wizardForm').on('submit', function(e) {
                            e.preventDefault();
                            $(this).find('.form-group').removeClass('has-error');
                            $('.help-block').text('');
                            axios.post(route('products.save'), $(this).getFormData())
                            .then(response => {
                                $.fn.notify(response.data.message);
                                location.assign(route('products.show', response.data.product.id));
                            }).catch(error => {
                                @include('partials.js-validation-errors')
                            })
                        })
                    </script>
                    @endpush
                       
