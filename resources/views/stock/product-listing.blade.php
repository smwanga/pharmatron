@extends('layouts.app')

@section('content')
    <div class="grid simple horizontal no-border green">
        <div class="grid-title">
            <h4><strong class="text-uppercase">{{$pagetitle}}</strong></h4>
        </div>
        <div class="grid-body row-fluid">
            <div class="col-sm-12 row">
                <div class="col-sm-4 pull-right">
                    <div class="p-b-40 ">
                        <form id="search-form">
                            <div class="input-group">
                                <input placeholder="Product Name or barcode " name="query" value="{{request()->get('query')}}" type="text" class="form-control">
                                <span class="input-group-addon primary" onclick="$('#search-form').submit()" style="cursor: pointer;">    
                                    <span class="arrow"></span>
                                        <i class="fa fa-search"></i>
                                    <strong>@lang('main.search')</strong>
                                </span>
                            </div>       
                        </form>   
                    </div>
                </div>
            </div>
            <div class="cards">
                @foreach($products as $product)
                    <div class="col-sm-4 col-md-3">
                        <div class="product-card card-01">
                            <div class="profile-box">
                                <img class="card-img-top" src="{{asset('assets/img/no_image.jpg')}}" alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <span class="badge-box"><div class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle card-fab-icon" href="#"><i class="fa fa-chevron-down"></i></a>
                                @include('partials.product-menu')
                                </div>
                                </span>
                                <h5 class="card-title text-center">{{$product->item_name}}</h5>
                                <strong class="pull-left" style="padding-left: 15px;">@lang('main.available'): </strong> &nbsp; {{number_format($product->available_stock)}} {{str_plural($product->dispensing_unit, $product->available_stock)}}
                                <br>
                                    <strong class="pull-left" style="padding-left: 15px;">
                                        @lang('main.formulation'):
                                    </strong> &nbsp; {{$product->category->category}}
                                    <br><br>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush