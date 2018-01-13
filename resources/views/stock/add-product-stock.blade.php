
@extends('layouts.app')

@section('content')
    <div class="grid simple horizontal no-border">
    	<div class="grid-title">
    		<strong class="text-uppercase">@lang('main.add_stock')</strong>
    	</div>
        <div class="grid-body row-fluid">
        	<div class="m-t-40 m-b-40">
	            <div class="input-group">
	                <input type="text" class="form-control input-lg search">
	                <span class="input-group-addon primary">		
					<span class="arrow"></span>
	                    <i class="fa fa-barcode"></i> SEARCH PRODUCT
	                </span>
	            </div>
	        </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
   $('.search').autocomplete({
            serviceUrl:'{{ route('products.search') }}',
            onSelect: function (result) {
                window.location.href = '{{ request()->root() }}/stock/'+result.data.id+'/add';
            }
        });
</script>
@endpush