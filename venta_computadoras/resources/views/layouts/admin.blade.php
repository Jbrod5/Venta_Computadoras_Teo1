<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Admin')</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
  @include('partials.navbaradmin')

  <div class="container mt-4">
    @yield('content')
  </div>
</body>
</html>
