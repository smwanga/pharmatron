@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="grid simple vertical no-bodder">
            <div class="grid-body">
                <div class="row">
                    <a href="?group=product"  class="btn btn-default"><i class="fa fa-folder-open"></i> @lang('main.products')</a>
                    <a href="?group=dispense_unit"  class="btn btn-default"><i class="fa fa-wrench"></i> @lang('main.dispense_unit')</a>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary pull-right ajaxModal btn-small"><i class="fa fa-plus"></i> &nbsp; @lang('main.add_category')</a>
                </div>
                <hr>
                <div class="row-fluid">
                    <div class="table-responsive">
                        <table id="products-table" class="table table-striped" style="width: 100%; cellspacing: 0;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('main.category')</th>
                                    <th>@lang('main.group')</th>
                                    <th>@lang('main.notes')</th>
                                    <th class="text-right">@lang('main.actions')</th>
                                </tr>
                            </thead>
                            
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('main.category')</th>
                                    <th>@lang('main.group')</th>
                                    <th>@lang('main.notes')</th>
                                    <th class="text-right">@lang('main.actions')</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
$(function() {
    tableElement.fnDestroy()
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('categories.get_data').'?'.http_build_query(request()->input()) !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'category', name: 'category' },
            { data: 'group', name: 'group' },
            { data: 'description', name: 'description' },
            { data: 'action', name: 'actions', orderable: false, searchable: false}
        ]
    });
});
</script>
@endpush
