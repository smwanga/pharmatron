
                @extends('partials.form-wizard')
                    @section('form-body')
                        <div class="tab-pane active fade in" id="tab1">
                            <div class="row m-b-lg">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="row">
                                        @include('components.errors')
                                        <div class="form-group col-md-6">
                                            <label for="name">@lang('main.supplier_name')</label>
                                            <input value="{{old('supplier_name', $supplier->supplier_name)}}" type="text" class="form-control" name="supplier_name" id="name" placeholder="Name of supplier">
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label for="stockCode">@lang('main.email')</label>
                                            <input type="email" value="{{old('supplier_email', $supplier->supplier_email)}}" class="form-control col-md-6" name="supplier_email" id="email" placeholder="@lang('main.example_email')">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="phone">@lang('main.phone')</label>
                                            <input type="text" value="{{old('supplier_phone', $supplier->supplier_phone)}}" class="form-control" name="supplier_phone" id="phone" placeholder="Primary phone number">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="website">@lang('main.website')</label>
                                            <input value="{{old('supplier_website', $supplier->supplier_website)}}" type="text" class="form-control" name="supplier_website" id="website" placeholder="@lang('main.example_site')">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="address">@lang('main.address')</label>
                                            <input type="text" value="{{old('supplier_address', $supplier->supplier_address)}}" class="form-control" name="supplier_address" id="address" placeholder="Full Address">
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label for="alert">@lang('main.notes')</label>
                                            <textarea class="form-control" name="notes" rows="4" >{{old('notes', $supplier->notes)}}</textarea>
                                        </div>
                                        <div class="form-group col-m5-12">
                                            <button class="btn btn-primary pull-right"><i class="fa fa-check"></i> &nbsp; @lang('main.update') </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endsection
                       
