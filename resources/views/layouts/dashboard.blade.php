<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="/assets/select2/css/select2.css" />
  <link rel="stylesheet" href="/assets/datepicker/dist/datepicker.css" />
  <link rel="stylesheet" href="/assets/stacktable/stacktable.css" />
  <link rel="stylesheet" href="/assets/jquerytoast/jquerytoast.css" />
  <link rel="stylesheet" href="/assets/custom/css/general.css" />
  <link rel="stylesheet" href="/assets/custom/css/rewrite.css" />
  <link rel="stylesheet" href="/assets/fontawesome/css/font-awesome.css">
  <link rel="stylesheet" href="/assets/jqueryrating/themes/fontawesome-stars.css">
  <link rel="icon" type="image/x-icon" href="/files/images/lengko-favicon.png" />
  <title>@yield('title')</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row min-height-80">
      <div id="navbar" class="col-md-2">
        @include('layouts.navbar')
      </div>
      <div id="content" class="col-md-10">
        @yield('content')
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 padd-lr-0">
        @include('addition')
        <footer class="footer">
          @yield('footer-quote')
        </footer>
      </div>
    </div>
  </div>
  @yield('lengko-loading')
  
  <script type="text/javascript" data-cfasync="false" src="/assets/jquery/jquery.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/sweetalert/sweetalert.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/select2/js/select2.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/datepicker/dist/datepicker.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/stacktable/stacktable.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/jquerytoast/jquerytoast.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/jqueryrating/jquery.barrating.min.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/chartjs/chart-2.7.1.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/custom/js/chart-data.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/custom/js/general.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/custom/js/dashboard.js"></script>
</body>

</html>
