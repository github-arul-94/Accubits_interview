<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Apps</title>
  <link rel="stylesheet" href="{{asset('assets/css/base.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}" />
  
  <script type="text/javascript" src="{{asset('assets/js/jquery-1.10.2.min.js')}}"></script>
</head>
<body style="background: #eee;">
  <div class="container" style="border: 1px solid #ddd;margin: 100px auto;width: 700px;background: #fff;">
    @yield('main')
  </div>
  
</body>
</html>

