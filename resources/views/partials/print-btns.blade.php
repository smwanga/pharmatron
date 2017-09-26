<div class="col-sm-12 hidden-print">
    <div class="btn-group m-b-20 pull-right">
         @php
            $data = request()->input();
            $download = array_merge($data, ['print' => 'download']);
            $print = array_merge($data, ['print' => 'print']);
        @endphp
        @isset($js_print)
        <button  onclick="print()" class="btn {{$size}} btn-primary">
            <i class="fa fa-print"></i>
        </button>
        @endisset
        @isset($btns)
        @foreach($btns as $btn)
        <button  onclick="location.href = '{!! $btn['url'] !!}'" class="btn {{$btn['class']}} btn-white">
            <i class="{{$btn['icon']}}"></i> 
        </button>
        @endforeach
        @endisset
        <button  onclick="location.href = '?{!!http_build_query($print)!!}'" class="btn {{$size}} btn-white">
            <i class="fa fa-print"></i>
        </button>
        <button  onclick="location.href = '?{!!http_build_query($download)!!}'" class="btn {{$size}} btn-white">
            <i class="fa fa-cloud-download"></i>
        </button>
    </div>
</div>