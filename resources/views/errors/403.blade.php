
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>403 Permission Denied || {{app_config('site_name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN PLUGIN CSS -->
    <link href="{{asset('assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('assets/plugins/bootstrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/bootstrapv3/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/animate.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PLUGIN CSS -->
    <!-- BEGIN CORE CSS FRAMEWORK -->
    <link href="{{asset('webarch/css/webarch.css')}}" rel="stylesheet" type="text/css" />
    <!-- END CORE CSS FRAMEWORK -->
  </head>
  <!-- END HEAD -->
  <!-- BEGIN BODY -->
  <body class="error-body no-top">
    <div class="error-wrapper container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-offset-1 col-xs-10">
          <div class="error-container">
            <div class="error-main">
              <div class="error-number"> 403 </div>
              <div class="error-description"> You dont have permission to view this page </div>
              <div class="error-description-mini"> The page your looking for is protected, If you think this is an error contact the system administrator </div>
              <br>
              <br>
              <a class="btn btn-primary btn-cons" href="{{route('home')}}">Go To Dashboard</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="footer">
      <div class="error-container">
        <ul class="footer-links">
          <li><a href="#">Copyrights & Privacy </a></li>
          <li><a href="#">Help & FAQ</a></li>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">Reports</a></li>
          <li><a href="#">Search</a></li>
        </ul>
        <br>
        <br>
        <div class="copyright"> All work copyright of respective owner, {{date('Y')}} {{app_config('site_name')}} </div>
      </div>
    </div>
    <!-- END CONTAINER -->
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
    <script src="{{asset('webarch/js/webarch.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/chat.js')}}" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->
  </body>
</html>