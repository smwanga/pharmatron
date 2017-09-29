@extends('users.user-profile')
@section('profile-content')
<div class="col-md-12">
    <ul class="cbp_tmtimeline">
        @foreach($timeline as $log)
        <li>
            <time class="cbp_tmtime" datetime="2013-04-10 18:30">
                <span class="">{{$log->created_at->diffForHumans()}}</span>
                <span class="time">{{$log->created_at->format('H:i')}}</span>
            </time>
            <div class="cbp_tmicon {{$log->action}} animated bounceIn"> <i class="{{$log->icon}}"></i> </div>
            <div class="cbp_tmlabel">
                <div class="p-t-10 p-l-30 p-r-20 p-b-20 xs-p-r-10 xs-p-l-10 xs-p-t-5">
                    <h4 class="inline m-b-5"><span class="text-success semi-bold">@lang('main.'.$log->type)</span> </h4>
                    <div class="muted">{{$log->created_at->format('l d F Y')}}</div>
                    <p class="m-t-5 dark-text"> {{$log->details}} </p>
                </div>
                <div class="clearfix"></div>
            </div>
        </li>
        @endforeach
    </ul>
     <div class="row m-t-20">
        <center>
            {!! $timeline->render() !!}
        </center>
    </div>
</div>
@endsection