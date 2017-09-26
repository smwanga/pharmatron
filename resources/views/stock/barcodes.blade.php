@extends('layouts.app')
@section('content')
    <div class="grid simple horizontal no-border">
        <div class="grid-body row-fluid">
            <div class="col-sm-12 hidden-print">
                <span class="h4">Barcodes for {{$product->item_name}}</span> <button onclick="print()" class="btn btn-primary pull-right"><i class="fa fa-print"></i></button>
            </div>
            <hr class="hidden-print">
            @for($i = 1; $i <=40; $i++)
            <div class="col-sm-3 text-center m-b-20" > 
                <center style="border:1px solid #d6d6d6">
                    <small class="no-margin">{{$product->item_name}}</small>
                        <img class="barcode img-responsive" src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->barcode, "c128")}}" alt="barcode"   />
                        <p class="no-margin">{{$product->barcode}}</p>
                </center>
                
            </div>
            @endfor
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $('.barcode').css('height', 60).css('width', 180);
</script>
@endpush