
@extends('layouts.app')
    @section('content')
        <div class="grid simple horizontal no-border">
        	<div class="grid-title">
        		<strong class="text-uppercase">@lang('main.add_stock')</strong>
        	</div>
            <div class="grid-body row-fluid">
                <div class="col-lg-12" id="error-messages">
                    
                </div>
                <div class="dropzone" id="dropzone"></div>
            </div>
        </div>
    @endsection
    @push('scripts')
    <script type="text/javascript">
       Dropzone.autoDiscover = false;
       let mimes = [
                        'application/vnd.ms-excel',
                        'application/vnd.oasis.opendocument.spreadsheet', 
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ];
       var upload = $('#dropzone').dropzone({
                url:route('products.import.upload'),
                headers: {
                    "X-CSRF-TOKEN" : "{{csrf_token()}}"
                },
                paramName: 'importedFile',
                acceptedFiles: ".xls,.xlsx,.ods",
                dictDefaultMessage: 'Drag an excel sheet here to upload, or click to select one',
                accept: function(file, done) {
                    if (mimes.indexOf(file.type) === -1) {
                        done('Please upload a spreadsheet file format');
                        var that = this;
                        //remove file after 10 seconds
                        setTimeout(function() {
                            that.removeFile(file);
                        }, 10000);
                    } else {
                        done();
                    }
                },
                init: function(){
                    this.on('success', function(file, response) {
                        // Handle successful import here
                    });
                    this.on('error', function(file, error, xhr) {
                        if(xhr){
                            
                           if(xhr.status == 422){
                                errors = JSON.parse(xhr.response)
                                this.dictResponseError = errors.importedFile.toString();
                           }
                        }
                    });
                }
            });
    </script>
    @endpush