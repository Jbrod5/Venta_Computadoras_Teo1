<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Marca / Título -->
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
      Administrador: {{ Auth::user()->nombre }}
    </a>

    <!-- Botón para menú colapsable en móviles -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Opciones -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
             href="{{ route('admin.dashboard') }}">
            Inicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}"
             href="{{ route('usuarios.index') }}">
            Usuarios
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('inventario.*') ? 'active' : '' }}"
               href="{{ route('inventario.index') }}">
                Inventario
            </a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('ensambles.*') ? 'active' : '' }}"
               href="{{ route('ensambles.index') }}">
                Ensambles
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pedidos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Ventas</a>
        </li>
      </ul>

      <!-- Botón logout a la derecha -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">
              Cerrar sesión
            </button>
          </form>
        </li>
      </ul>
    </div>


    
  </div>
</nav>
