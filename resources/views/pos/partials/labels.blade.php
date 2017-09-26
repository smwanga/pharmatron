<div class="row page-print">
    @foreach($sale->items as $item)
    <div class="col-sm-6 content-data">
        <div class="grid simple vertical green">
            <div class="grid-body no-border">
                <div class="row-fluid ">
                     <h4>{{$item->product->item_name}}<span class="pull-right">{{$item->qty}}</span></h4>
                    <address class="margin-bottom-20 margin-top-10">
    				    {{$item->instructions}}
    				</address>
                    <address>
    				<strong class="h5">{{$sale->user->name}}</strong> <span class="pull-right">{{$sale->created_at->format('d-m-Y')}}</span><br>
    				</address>
                    <hr>
                   <address>
                        <strong class="h5">{{app_config('site_name')}}</strong><br>
                        <span><i class="fa fa-phone"></i> :</span> {{app_config('contact_phone')}}, <span><i class="fa fa-envelope-o"></i> : </span> {{app_config('contact_email')}}
                    </address>
                </div>
            </div>
        </div>
    </div>
    <div class="page-break"></div>
    @endforeach
</div>