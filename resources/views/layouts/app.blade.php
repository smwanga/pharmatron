<!DOCTYPE html>
<html>
  <head>
    <title>{{isset($pagetitle) ? $pagetitle.' || '.config('app.fullname') : config('app.fullname') }}</title>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="{{csrf_token()}}" name="csrf-token" />
    <!-- BEGIN PLUGIN CSS -->
    <link href="{{asset('assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('assets/plugins/bootstrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/bootstrapv3/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/animate.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" />
     <link href="{{asset('assets/plugins/pnotify/pnotify.custom.min.css')}}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('css/switchery.min.css')}}" rel="stylesheet" type="text/css" />
    @isset($forms)
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap-select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen" />
    @endisset
    @isset($datatables)
    <link href="{{asset('assets/plugins/jquery-datatable/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/datatables-responsive/css/datatables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />
    @endisset
    <!-- END PLUGIN CSS -->
    <!-- BEGIN CORE CSS FRAMEWORK -->
    <link href="{{asset('css/materialfonts.css')}}" rel="stylesheet">
    <link href="{{asset('webarch/css/webarch.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css" />
    <!-- END CORE CSS FRAMEWORK -->
    @routes
    @stack('css')
  </head>
  <body >
      <!-- BEGIN HEADER -->
        @include('components.navbar')
              
      <!-- END HEADER -->
      <!-- BEGIN CONTENT -->
      <div class="page-container row-fluid">
        <!-- BEGIN SIDEBAR -->
          @include('components.sidebar')
        <!-- END SIDEBAR -->
        <!-- BEGIN PAGE CONTAINER-->
        <div class="page-content">
          <div class="content">
            <!-- END PAGE TITLE -->
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
              <div id="main-wrapper">
                  <div class="row">
                    @yield('content')
                  </div><!-- Row -->
              </div><!-- Main Wrapper -->
            <!-- END PLACE PAGE CONTENT HERE -->
          </div>
        </div>
        <!-- END PAGE CONTAINER -->
      </div>
    <!-- END CONTENT -->
    <!-- BEGIN CORE JS FRAMEWORK-->
    <script src="{{asset('assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
    <!-- BEGIN JS DEPENDECENCIES-->
    <script src="{{asset('assets/plugins/jquery/jquery-1.11.3.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/bootstrapv3/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery-block-ui/jqueryblockui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery-unveil/jquery.unveil.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/pnotify/pnotify.custom.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/daterange/moment.min.js')}}" type="text/javascript"></script>    
    @isset($forms)
    <script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/daterange/daterangepicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/bootstrap-select2/select2.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.autocomplete.min.js')}}" type="text/javascript"></script>
    @endisset
    <!-- END CORE JS DEPENDECENCIES-->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="{{asset('webarch/js/webarch.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/chat.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/manifest.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/vendor.js')}}" type="text/javascript"></script>
    <script src="{{mix('js/app.js')}}" type="text/javascript"></script>
    <script src="{{mix('js/pharmatron.js')}}" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true"></div>
     <script type="text/javascript">
        $(".ajaxModal").on('click',function(e) {
            var url;
            url = $(this).attr('href');
            if(typeof url == 'undefined'){
              url = $(this).data('url');
            }
            md = $('#modal');
            md.load(url ,function( response, status, xhr ) {
                if ( status == "error" ) {
                   $.fn.notify('An internal server error has occured', 'Error loading resource', 'error')
                }
              });
              md.modal('show');
              e.preventDefault();
          });
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover "+$(this).data('name')+"!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then(willDelete => {
                    if (willDelete) {
                        axios.delete($(this).data('url')).then( response => {
                            swal("Poof! The item has been deleted!", {
                                icon: "success", 
                            });
                            setTimeout(function() {
                                 window.location.reload(true);
                            }, 2000);
                       });
                  } else {
                        swal("Delete Operation was cancelled"); 
                  }
                });
       })
    </script>
    @include('partials.notifications')
    @stack('scripts')

  </body>
</html>