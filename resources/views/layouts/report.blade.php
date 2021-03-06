<!DOCTYPE html>
<html id="print-area">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="/assets/slick/slick.css" />
  <link rel="stylesheet" href="/assets/slick/slick-theme.css" />
  <link rel="stylesheet" href="/assets/custom/css/general.css" />
  <link rel="icon" type="image/x-icon" href="/files/images/lengko-favicon.png" />
  @stack('style')
  <title>@yield('title')</title>
</head>

<body>
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        @yield('content')
      </div>
    </div>

  </div>
  @yield('lengko-loading')
  <script type="text/javascript" data-cfasync="false" src="/assets/jquery/jquery.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/slick/slick.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/custom/js/general.js"></script>
</body>

</html>
