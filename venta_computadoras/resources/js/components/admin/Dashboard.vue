<template>
  <div>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      Administrador: {{ Auth::user()->nombre }}
    </a>

    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.dashboard') }}">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('usuarios.index') }}">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Inventario</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Ensambles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pedidos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Ventas</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


    <!-- Contenido dinámico -->
    <div class="container mt-4">
      <div v-if="activeTab === 'home'">
        <h1 class="h4 fw-bold">📊 Reportes</h1>
        <p>Aquí irán los gráficos y estadísticas.</p>
      </div>
      <div v-if="activeTab === 'users'">
        <h1 class="h4 fw-bold">👤 Gestión de usuarios</h1>
      </div>
      <div v-if="activeTab === 'inventory'">
        <h1 class="h4 fw-bold">📦 Inventario</h1>
      </div>
      <div v-if="activeTab === 'assemblies'">
        <h1 class="h4 fw-bold">🔧 Ensambles</h1>
      </div>
      <div v-if="activeTab === 'orders'">
        <h1 class="h4 fw-bold">📑 Pedidos</h1>
      </div>
      <div v-if="activeTab === 'sales'">
        <h1 class="h4 fw-bold">💰 Ventas</h1>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AdminDashboard",
  props: {
    username: String
  },
  data() {
    return {
      activeTab: "home",
    };
  },
};
</script>
