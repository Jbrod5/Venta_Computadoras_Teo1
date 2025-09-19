<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">


    <!-- Botón responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavCliente">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavCliente">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('cliente.index') ? 'active' : '' }}" href="{{ route('cliente.index') }}">
            Componentes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('cliente.componentes.index') ? 'active' : '' }}" href="{{ route('cliente.componentes.index') }}">
            Ensambles
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('carrito.index') ? 'active' : '' }}" href="{{ route('carrito.index') }}">
            Carrito
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('cliente.pedidos') ? 'active' : '' }}" href="{{ route('cliente.pedidos') }}">
            Mis Pedidos
          </a>
        </li>
      </ul>

    
    
    <!-- Marca -->
    <a class="navbar-brand" href="{{ route('cliente.index') }}">
      Cliente: {{ Auth::user()->nombre }}
    </a>

      <!-- Logout -->
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
