@extends('suppliers.supplier-profile')

@section('profile-content')
<div class="row-fluid">
    <div class="grid simple horizontal green">
        <div class="grid-title">
            <strong>@lang('main.purchase_orders')</strong>
        </div>
        <div class="grid-body">
            @include('inventory.partials.lpo-list')
        </div>
    </div>
</div>
@endsection