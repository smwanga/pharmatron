<ul class="dropdown-menu pull-right">
    <li>
        <a href="{{ route('products.edit', $product->id) }}"> <span class="fa fa-pencil m-r-xs"></span> &nbsp; @lang('main.edit_product')</a>
    </li>
    <li> 
        <a href="{{ route('products.show', $product->id) }}"> <span class="fa fa-eye m-r-xs"></span> &nbsp; @lang('main.view')</a>
    </li>
   {{--  <li>  
        <a href="#"> <span class="fa fa-bar-chart m-r-xs"></span> &nbsp; @lang('main.view_stock_movement')</a> 
    </li> --}}
    <li> 
        <a href="{{ route('products.barcodes.show', $product->id) }}"> <span class="fa fa-barcode m-r-xs"></span> &nbsp; @lang('main.print_barcodes')</a>
    </li>
    <li> 
        <a href="{{ route('stock.create', $product->id) }}"> <span class="fa fa-plus m-r-xs"></span> &nbsp; @lang('main.add_stock')</a>
    </li>
    <li> 
        <a href="" data-url="{{ route('products.delete', $product->id) }}" class="delete-btn" data-name="{{$product->item_name}}"> <span class="fa fa-trash m-r-xs"></span> &nbsp; @lang('main.delete')</a>
    </li>
</ul>