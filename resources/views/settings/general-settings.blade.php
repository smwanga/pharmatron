@extends('settings.app-settings')
@section('content')
<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="grid simple horizontal green">
    <div class="grid-title">
        General Settings
    </div>
    <div class="grid-body">
        <form id="general-form" action="{{ route('settings.config.update') }}" class="form-horizontal" style="width: 100%;" method="post" enctype="multipart/form-data" runat="server">
            {{csrf_field()}}
            <div class="form-group">
                <strong class="col-sm-3 control-label">Site Name</strong>
                <div class="col-sm-9">
                    <input type="text" name="site_name" class="form-control" value="{{$config->site_name}}">
                </div>           
            </div>
             <div class="form-group">
                <strong class="col-sm-3 control-label">Company Address</strong>
                <div class="col-sm-9">
                    <input type="text" name="address" class="form-control" value="{{$config->address}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">Contact Phone</strong>
                <div class="col-sm-9">
                    <input type="text" name="contact_phone" class="form-control" value="{{$config->contact_phone}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">Company E-Mail</strong>
                <div class="col-sm-9">
                    <input type="text" name="contact_email" class="form-control" value="{{$config->contact_email}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">City</strong>
                <div class="col-sm-9">
                    <input type="text" name="city" class="form-control" value="{{$config->city}}">
                </div>           
            </div>
            <div class="form-group">
                <strong class="col-sm-3 control-label">Postal Code</strong>
                <div class="col-sm-9">
                    <input type="text" name="zip_code" class="form-control" value="{{$config->zip_code}}">
                </div>           
            </div>
           <div class="form-group">
                <strong class="col-sm-3 control-label">Logo</strong>
                <div class="col-sm-9">
                    <div class="image-cropper" style="max-height: 250px; max-width: 250px;">
                        <img src="{{asset('img/'.$config->app_logo)}}">
                        <input type="file" name="invoice_logo" accept="image/*"  id="logo-img" onchange="loadImage(this)">
                    </div>
                </div>        
            </div>
            <input type="hidden" name="w" id="w" />
            <input type="hidden" name="h" id="h" />
            <input type="hidden" name="x" id="x" />
            <input type="hidden" name="y" id="y" />
            <input type="hidden" name="x1" id="x1" />
            <input type="hidden" name="y1" id="y1" />
            <div class="col-sm-12">
                <button class="btn btn-success pull-right" type="submit"><i class="fa fa-save"></i> &nbsp; @lang('main.save')</button>
            </div>
        </form>
        <!-- Modal -->
        <div id="image-crop" class="modal fade" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Crop Logo</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <div class="" style="height: 350px; width: 450px;">
                                <img src="{{asset('img/'.$config->app_logo)}}" id="logo-preview">
                            </div>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button id="cropper-btn" type="button" class="btn btn-primary">Crop Image</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE -->
@endsection
@push('css')
        <link rel="stylesheet" href="{{asset('css/cropper.min.css')}}">
    @endpush
    @push('scripts')
        <script src="{{asset('js/cropper.min.js')}}"></script>
        <script>
        function loadImage($input) {
            if ($input.files && $input.files[0]) {
                var reader = new FileReader();
                var image = $('#logo-preview');
                reader.onload = function(e) {
                    image.prop('src', reader.result);
                    var cropper = image.cropper({
                        aspectRatio: 1,
                        crop: (e) => {
                            $('#x').val(e.x);
                            $('#y').val(e.y);
                            $('#w').val(e.width);
                            $('#h').val(e.height);
                            $('#x1').val(e.scaleX);
                            $('#y1').val(e.scaleY);
                        }
                    });
                    $('#image-crop').modal('show');
                    $("#image-crop").on("hidden.bs.modal", function () {
                        image.cropper('destroy');
                    });
                }
                reader.readAsDataURL($input.files[0]);
                
            }
        }
        $('#cropper-btn').click((event) => {
            $('#general-form').submit();
        });
</script>
@endpush