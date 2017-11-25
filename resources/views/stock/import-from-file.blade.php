
@extends('layouts.app')
    @section('content')
        <div class="grid simple horizontal no-border">
        	<div class="grid-title">
        		<strong class="text-uppercase">@lang('main.import_products')</strong>
        	</div>
            <div class="grid-body row-fluid">
                <div class="col-lg-12">
                    <p class="h4">Download the sample excel file by clicking the download button and fill in the product details, please take note of these rules</p>
                    <ol>
                        <li><b>DO NOT</b> change the column headers.</li>
                        <li>The Dispensing unit <b>MUST</b> be exisiting in the categories section and is case sensitive</li>
                        <li>The stock code should be unique</li>
                        <li>After adding your products to the excel file, come back here select the file and hit the upload button</li>
                    </ol>
                </div>
                <form action="{{ route('products.import.upload') }}" enctype="multipart/form-data" method="POST">
                    {{csrf_field()}}
                    <div class="box form-group {{ error('importedFile') }}">
                        <input type="file" name="importedFile" id="file-5" class="inputfile inputfile-4 hide" accept=".xls, .ods, .xlsx" />
                        <label for="file-5"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span>Choose an excel file to upload &hellip;</span></label>
                        {!! error_msg('importedFile') !!}
                    </div>
                    @if($handler = session('handler'))
                    <div class="form-group">
                        <div class="alert alert-success">
                            <strong>{{$handler->importedCount}} of {{$handler->productCount}} products were imported successfully</strong>
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <a href="{{ route('products.import.download') }}" class="btn btn-success"><i class="fa fa-download"></i> &nbsp; Download Sample File</a>
                        <button type="submit" class="pull-right btn btn-lg btn-primary"><i class="fa fa-upload"></i> &nbsp; Upload File</button>
                    </div>
                </form>
            </div>
        </div>
            @if($uploadErrors = session('uploadErrors'))
            <div class="grid horizontal simple red">
                <div class="grid-title">
                    <strong>Import Log</strong>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="grid-body">
                    <h5>These Errors were encountered during the upload</h5>
                    <div class="alert alert-danger"> 
                    @if(is_array($uploadErrors))
                        @foreach($uploadErrors as $item => $importErrors)
                        <strong>{{ucwords(str_replace('-', ' ', $item))}}</strong>
                        <ol>
                            @foreach($importErrors as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ol>
                        @endforeach
                    @endif
                    </div>
                </div>
             @endif
            </div>
        </div>
    @endsection
    @push('scripts')
    <script type="text/javascript">
       let mimes = [
                        'application/vnd.ms-excel',
                        'application/vnd.oasis.opendocument.spreadsheet', 
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ];

;( function( $, window, document, undefined )
{
    $( '.inputfile' ).each( function()
    {
        var $input   = $( this ),
            $label   = $input.next( 'label' ),
            labelVal = $label.html();

        $input.on( 'change', function( e )
        {
            var fileName = '';

            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else if( e.target.value )
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                $label.find( 'span' ).html( fileName );
            else
                $label.html( labelVal );
        });

        // Firefox bug fix
        $input
        .on( 'focus', function(){ $input.addClass( 'has-focus' ); })
        .on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
    });
})( jQuery, window, document );
    </script>
    @endpush