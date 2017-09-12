@extends('layouts.app')
    @section('content')
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple horizontal green">
                        <div class="grid-title"><h4><strong class="text-uppercase">{{$pagetitle}}</strong></h4></div>
                        <div class="grid-body">
                            <div id="rootwizard">
                                <ul class="nav nav-tabs" role="tablist">
                                    @foreach($titles as $title)
                                    <li role="presentation" class="active">
                                        <a href="#tab1" data-toggle="tab"><i class="{{$title->icon}} m-r-xs"></i>{{$title->title}}</a>
                                    </li>
                                    @endforeach
                                    @php
                                        $per = 100/count($titles);
                                    @endphp
                                </ul>
                                <form id="wizardForm" novalidate="novalidate" action="{{$wizard->form->action}}" method="post" enctype="mulipart/form-data">
                                    {{csrf_field()}}
                                    {{method_field($wizard->form->method)}}
                                    <div class="tab-content">
                                        @yield('form-body')
                                        @yield('form-footer')
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endsection
