<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <title>{{isset($pagetitle) ? $pagetitle.' || '.config('app.fullname') : config('app.fullname') }}</title>
    <!-- BEGIN PLUGIN CSS -->
    <link href="{{asset('assets/plugins/bootstrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/bootstrapv3/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css" />
    <!-- END CORE CSS FRAMEWORK -->
  </head>
  <body class="">
      <div class="container">
          <div class="container-fluid">
              @yield('content')
          </div><!-- Row -->
      </div><!-- Main Wrapper -->
    <!-- END PLACE PAGE CONTENT HERE -->
  </body>
</html>