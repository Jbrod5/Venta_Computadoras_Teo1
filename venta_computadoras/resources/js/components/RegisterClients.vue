<template>
  <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow" style="width: 400px;">
      <h2 class="card-title text-center mb-4">Registrarse como Cliente</h2>

      <form @submit.prevent="register">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" v-model="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" v-model="correo" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" v-model="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Dirección</label>
          <input type="text" v-model="direccion" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Teléfono</label>
          <input type="tel" v-model="telefono" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Registrarse</button>
      </form>

      <p v-if="error" class="text-danger mt-3 text-center">{{ error }}</p>
      <p v-if="success" class="text-success mt-3 text-center">{{ success }}</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      nombre: '',
      correo: '',
      password: '',
      direccion: '',
      telefono: '',
      error: '',
      success: ''
    }
  },

  methods: {
    async register() {
      try {
        let response = await fetch('/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            nombre: this.nombre,
            correo: this.correo,
            pass: this.password,
            direccion: this.direccion,
            telefono: this.telefono
          })
        })

        let data = await response.json()

        if (!response.ok) {
          throw new Error(data.error || 'Error desconocido')
        }

        this.success = 'Registro completo!! :3'
        this.error = ''
      } catch (err) {
        this.error = err.message
        this.success = ''
      }
    }
  }
}
</script>
