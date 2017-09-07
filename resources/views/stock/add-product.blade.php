
                @extends('partials.form-wizard')
                    @section('form-body')
                        <div class="tab-pane active fade in" id="tab1">
                        @include('components.errors')
                            <div class="row m-b-lg">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="genericName">@lang('main.generic_name')</label>
                                            <input value="{{old('generic_name')}}" type="text" class="form-control" name="generic_name" id="genericName" placeholder="Product name">
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label for="stockCode">@lang('main.product_code')</label>
                                            <input type="text" class="form-control col-md-6" name="stock_code" value="{{old('stock_code')}}" id="stockCode" placeholder="Stock Code">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="barcode">@lang('main.barcode')</label>
                                            <div class="input-group">
                                            <input value="{{old('barcode')}}" type="number" class="form-control" name="barcode" id="barcode" placeholder="Product's Barcode">
                                            <span id="generate-code" style="cursor: pointer; color:#fff !important;" class="input-group-addon primary">
                                                <span class="arrow"></span>
                                                <span style="color:#fff !important;"  class="addon" data-toggle="tooltip" title="Generate Barcode"><i class="fa fa-barcode"></i></span>
                                                    </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputPassword1">@lang('main.category')</label>
                                            <select class="select2" name="category_id">
                                                <optgroup label="@lang('main.categories')">
                                                    @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->category}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="unit">@lang('main.dispense_unit')</label>
                                            <select class="select2" name="unit">
                                                <optgroup label="@lang('main.dispense_unit')">
                                                    @foreach($dispense_unit as $unit)
                                                    <option value="{{$unit->id}}">{{$unit->category}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="alert">@lang('main.alert_level')</label>
                                            <input value="{{old('alert_level')}}" type="number" class="form-control" name="alert_level" id="alert" placeholder="Level to alert low stock">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="description">@lang('main.description')</label>
                                            <textarea class="form-control" rows="4" name="description" id="description" placeholder="Product description">{{old('description')}}</textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="notes">@lang('main.notes')</label>
                                            <textarea class="form-control" rows="4" name="notes" id="notes" placeholder="@lang('main.notes')">{{old('notes')}}</textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="instructions">@lang('main.instructions')</label>
                                            <textarea class="form-control" rows="4" name="instructions" id="instructions" placeholder="Usage instructions">{{old('instructions')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                            <button class="btn btn-primary pull-right" type="submit"><span class="fa fa-check"></span> &nbsp; @lang('main.save')</button>
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
                       
