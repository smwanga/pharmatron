@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="grid simple vertical no-bodder">
            <div class="grid-body">
                <div class="col-sm-12">
                    <div class="col-xs-10">
                        <p> Easily group products by a common attribute, i.e Drugs that are distributed as tablets can be put in a category <code> Tablets </code> with <code>Dispensing unit</code> as the group</p>
                    </div>
                    <div class="col-xs-2">
                        <button data-toggle="dropdown" href="#" class="btn btn-small btn-white pull-right">
                             Options
                             &nbsp;&nbsp;&nbsp; <i class="caret"></i>
                         </button>
                         <ul class="dropdown-menu pull-right">
                             <li>
                                <a href="?group=product">
                                    <i class="fa fa-folder-open"></i> 
                                    @lang('main.products')
                                </a>
                            </li>
                            <li>
                                <a href="?group=dispense_unit">
                                    <i class="fa fa-wrench"></i> 
                                    @lang('main.dispense_unit')
                                </a>
                            </li>
                            @can('manage_stock_categories')
                            <li>
                                <a href="{{ route('categories.create') }}" class="ajaxModal">
                                    <i class="fa fa-plus"></i> 
                                    &nbsp; @lang('main.add_category')
                                </a>
                            </li>
                            @endcan
                         </ul>
                    </div>
                    
                    
                </div>
                <hr>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="products-table" class="table table-striped" style="width: 100%; cellspacing: 0;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('main.category')</th>
                                    <th>@lang('main.group')</th>
                                    <th>@lang('main.notes')</th>
                                    @can('manage_stock_categories')
                                    <th class="text-right">@lang('main.actions')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $key => $category)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$category->category}}</td>
                                    <td>{{trans('main.'.$category->group)}}</td>
                                    <td>{{$category->description}}</td>
                                     @can('manage_stock_categories')
                                    <td><a data-url="{{ route('categories.edit', $category->id) }}" class="ajaxModal btn btn-mini btn-success"><i class="fa fa-pencil"></i></a></td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                            
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('main.category')</th>
                                    <th>@lang('main.group')</th>
                                    <th>@lang('main.notes')</th>
                                     @can('manage_stock_categories')
                                    <th class="text-right">@lang('main.actions')</th>
                                    @endcan
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
