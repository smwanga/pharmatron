@extends('layouts.app')

@section('content')
    <div class="grid simple horizontal no-border green">
        <div class="grid-title">
            <h4><strong class="text-uppercase">{{$pagetitle}}</strong></h4>
        </div>
        <div class="grid-body row-fluid">
            <div class="cards">
                @foreach($products as $product)
                    <div class="col-sm-4 col-md-3">
                        <div class="product-card card-01">
                            <div class="profile-box">
                                <img class="card-img-top" src="{{asset('assets/img/no_image.jpg')}}" alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <span class="badge-box"><div class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle card-fab-icon" href="#"><i class="fa fa-chevron-down"></i></a>
                                <ul class="dropdown-menu pull-right">
                                   <li>
                                <a href="{{ route('products.edit', $product->id) }}"> <span class="fa fa-pencil m-r-xs"></span> &nbsp; @lang('main.edit_product')</a>
                              </li>
                              <li> 
                                <a href="{{ route('products.show', $product->id) }}"> <span class="fa fa-eye m-r-xs"></span> &nbsp; @lang('main.view')</a>
                                </li>
                              <li>  
                                <a href="#"> <span class="fa fa-bar-chart m-r-xs"></span> &nbsp; @lang('main.view_stock_movement')</a> 
                                </li>
                              <li> 
                                <a href="#"> <span class="fa fa-barcode m-r-xs"></span> &nbsp; @lang('main.print_barcodes')</a>
                                </li>
                              <li> 
                                <a href="{{ route('stock.create', $product->id) }}"> <span class="fa fa-plus m-r-xs"></span> &nbsp; @lang('main.add_stock')</a>
                                </li>
                              <li> 
                                <a href="#"> <span class="fa fa-trash m-r-xs"></span> &nbsp; @lang('main.delete')</a>
                              </li>
                                </ul>
                                </div>
                                </span>
                                <h4 class="card-title text-center">{{$product->generic_name}}</h4>
                                <strong class="pull-left" style="padding-left: 15px;">@lang('main.available'): </strong> &nbsp; {{number_format($product->available_stock)}} {{str_plural($product->dispensing_unit, $product->available_stock)}}
                                <br>
                                    <strong class="pull-left" style="padding-left: 15px;">Category: </strong> &nbsp; {{$product->category->category}}
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