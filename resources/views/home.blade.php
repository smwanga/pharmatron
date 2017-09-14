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
                     <div class="card hovercard">
                <div class="cardheader">

                </div>
                <div class="avatar">
                    <img alt="" src="https://avatars1.githubusercontent.com/u/11767240?v=3&s=400">
                </div>
                <div class="info">
                    <div class="title">
                        <a target="_blank" href="">Kalyanasundaram</a>
                    </div>
                    <div class="desc">Backend Developer, ML</div>
                    <div class="desc">Developer at <b>Freshdesk</b></div>
                </div>
            </div>
            </div>
        </div>
@endsection
