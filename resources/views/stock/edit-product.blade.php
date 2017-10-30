
                @extends('partials.form-wizard')
                    @section('form-body')
                        <div class="tab-pane active fade in" id="tab1">
                        @include('components.errors')
                            <div class="row m-b-lg">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="genericName">@lang('main.item_name')</label>
                                            <input value="{{old('item_name', $product->item_name)}}" type="text" class="form-control" name="item_name" id="item_name" placeholder="Product name">
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label for="stockCode">@lang('main.generic_name')</label>
                                            <input type="text" class="form-control col-md-6" name="generic_name" value="{{old('stock_code', $product->generic_name)}}" id="stockCode" placeholder="Stock Code">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group  col-md-6">
                                            <label for="stockCode">@lang('main.product_code')</label>
                                            <input type="text" class="form-control col-md-6" name="stock_code" value="{{old('stock_code', $product->stock_code)}}" id="stockCode" placeholder="Stock Code">
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="barcode">@lang('main.barcode')</label>
                                            <input value="{{$product->barcode}}" type="number" class="form-control">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label for="alert">@lang('main.alert_level')</label>
                                            <input value="{{old('alert_level', $product->alert_level)}}" type="number" class="form-control" name="alert_level" id="alert" placeholder="Level to alert low stock">
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="unit">@lang('main.dispense_unit')</label>
                                            <select class="select2" name="unit">
                                                <optgroup label="@lang('main.dispense_unit')">
                                                    @foreach($dispense_unit as $unit)
                                                    <option {{$product->unit == $unit->id ? 'selected' : ''}} value="{{$unit->id}}">{{$unit->category}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                        
                                    </div>
                                <div class="col-md-6">
                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <label for="description">@lang('main.description')</label>
                                            <textarea class="form-control" rows="4" name="description" id="description" placeholder="Product description">{{old('description', $product->description)}}</textarea>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="instructions">@lang('main.instructions')</label>
                                            <textarea class="form-control" rows="4" name="instructions" id="instructions" placeholder="Usage instructions">{{old('instructions', $product->instructions)}}</textarea>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group col-sm-12">
                                        <button class="btn btn-success pull-right" type="submit">
                                            <i class="fa fa-pencil"></i> 
                                            &nbsp; @lang('main.update')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endsection
                    @push('scripts')
                    <script type="text/javascript">
                        $('#generate-code').on('click', function() {
                            var tmp = String(Math.floor(Math.random() * (616110999998 - 616110000000 + 1)) + 616110000000);
                            $('#barcode').barcode(tmp);
                        })
                    </script>
                    @endpush
                       
