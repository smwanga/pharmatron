@extends('layouts.app')
    @section('content')
        <div class="col-sm-12 hidden-print row">
    <div class="btn-group m-b-20 pull-right">

        <button  onclick="print()" class="btn btn-small btn-primary">
            <i class="fa fa-print"></i>
        </button>
    </div>
</div>
        @include('pos.partials.labels')
    @endsection