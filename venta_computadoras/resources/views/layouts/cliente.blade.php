<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Cliente')</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
  @include('partials.navbarcliente')

  <div class="container mt-4">
    @yield('content')
  </div>
</body>
</html>
