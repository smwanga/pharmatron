@extends('layouts.app')

@section('content')
        <div class="grid horizontal simple green">
            <div class="grid-title"><h4>{{$pagetitle}}</h4></div>
                <div class="grid-body">
                    @foreach($suppliers as $supplier)
                    <div class="col-sm-4">
                         <div class="card hovercard">
                            <div class="cardheader">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle card-link pull-right btn btn-warning"><i class="fa fa-chevron-down m-r-md"></i></a>
                            <ul class="dropdown-menu pull-right" style="position: static;">
                                <li><a href="{{ route('suppliers.edit', $supplier->id) }}"><i class="fa fa-pencil"></i> &nbsp; @lang('main.edit')</a></li>
                                <li><a href="{{ route('suppliers.show', $supplier->id) }}"><i class="fa fa-eye"></i> &nbsp; @lang('main.view')</a></li>
                            </ul>
                            </div>
                            <div class="avatar">
                                <img alt="" src="{{ asset('img/avatar.png') }}">
                            </div>
                            <div class="info">
                                <div class="title">
                                    <a target="_blank" href="{{$supplier->supplier_website ?: '#'}}">{{$supplier->supplier_name}}</a>
                                </div>
                                <div class="desc">{{$supplier->supplier_phone}}</div>
                                <div class="desc">{{$supplier->supplier_email}}<b></div>
                            </div>
                            <div class="bottom">
                                
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
@endsection
