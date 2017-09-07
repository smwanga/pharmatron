@extends('layouts.app')

@section('content')
    <div class="grid simple vertical no-border">
        <div class="grid-body row-fluid">
            <table class="table table-striped table-condensed" id="products-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Generic Name</th>
                        <th>Product Code</th>
                        <th>Barcode Number</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
<script>
$(function() {
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('products.get_data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'generic_name', name: 'generic_name' },
            { data: 'stock_code', name: 'stock_code' },
            { data: 'barcode', name: 'barcode' },
            { data: 'category', name: 'category', searchable: false},
            { data: 'action', name: 'actions', orderable: false, searchable: false}
        ]
    });
});
</script>
@endpush