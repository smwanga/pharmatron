@extends('layouts.app')

@section('content')
        <div class="grid horizontal simple green">
            <div class="grid-title"><h4>{{$pagetitle}}</h4></div>
                <div class="grid-body">
                    @forelse($companies as $company)
                    <div class="col-sm-3">
                         <div class="card hovercard">
                            <div class="cardheader">
                            <a href="{{ route('companies.show', $company->id) }}" class="card-link pull-right btn btn-primary"><i class="fa fa-arrow-right"></i></a>
                            </div>
                            <div class="avatar">
                                <img alt="" src="{{ asset('img/avatar.png') }}">
                            </div>
                            <div class="info">
                                <div class="title">
                                    <a target="_blank" href="{{$company->website ?: '#'}}">{{$company->company_name}}</a>
                                </div>
                                <div class="desc">{{$company->phone}}</div>
                                <div class="desc">{{$company->email}}<b></div>
                            </div>
                            <div class="bottom">
                                
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-sm-12">
                        <div class="m-t-40 p-t-20">
                            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 text-center">
                                <p>There is no company to be display here. Create your first company?</p>
                                <a href="{{ route('companies.create') }}" class="btn-primary btn"><i class="fa fa-plus"></i>  @lang('main.create_company')</a>
                            </div>
                        </div>
                    </div>
                    @endforelse
            </div>
        </div>
@endsection
