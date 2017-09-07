<!DOCTYPE html>
<html>
  <head>
    <title>Title Goes Here</title>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN PLUGIN CSS -->
    <link href="{{asset('assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('assets/plugins/bootstrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/bootstrapv3/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/animate.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PLUGIN CSS -->
    <!-- BEGIN CORE CSS FRAMEWORK -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="webarch/css/webarch.css')}}" rel="stylesheet" type="text/css" />
    <!-- END CORE CSS FRAMEWORK -->
  </head>
  <body class="">
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
          <!-- BEGIN PAGE TITLE -->
          <div class="page-title">
            <h3>Master Page</h3>
            <div class="page-breadcrumb">
              {!! Breadcrumbs::render() !!}
            </div>
          </div>
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
    <script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/bootstrap-select2/select2.min.js')}}" type="text/javascript"></script>
    <!-- END CORE JS DEPENDECENCIES-->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="webarch/js/webarch.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/chat.js')}}" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->
  </body>
</html>