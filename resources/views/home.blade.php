@extends('layouts.app')

@section('content')
        <div class="grid horizontal simple green">
            <div class="grid-title"><h4>Dashboard</h4></div>
                <div class="grid-body">
                @if (session('status'))
                    <div class="alert alert-success">
                            {{ session('status') }}
                    </div>
                 @endif
                 <h1>Dashboard Page Content Design In Progress</h1>
            </div>
        </div>
@endsection
