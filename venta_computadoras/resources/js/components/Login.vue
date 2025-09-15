<template>
  <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow" style="width: 350px;">
      <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>

      <form @submit.prevent="login">
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" v-model="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" v-model="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
      </form>

      <p v-if="error" class="text-danger mt-3 text-center">{{ error }}</p>

      
      <p class="text-center mt-3">
        ó
        <br>
        <a href="/register">Regístrate como cliente</a>
      </p>

    </div>
  </div>
</template>

<script>


export default {
  data() {
    return {
      email: '',
      password: '',
      error: ''
    }
  },

  
  methods: {
    async login() {
      try {
        let response = await fetch('/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password
          })
        })




        let data = await response.json()


        if (!response.ok) {
          // Aquí usamos el mensaje que envía Laravel
          throw new Error(data.error || 'Error desconocido');
        }

        //Guardar el tipo de usuario y el nombre :3
        localStorage.setItem('tipo_usuario', data.tipo_usuario);
        localStorage.setItem('user', data.user);
        alert(`Bienvenido ${data.user}`)



        // Redirigir a la pagina que corresponda :3
        if (parseInt(data.tipo_usuario) === 1) {
          window.location.href = '/admin';
        } else if (parseInt(data.tipo_usuario) === 2) {
          window.location.href = '/tecnico';
        } else {
          window.location.href = '/cliente';
        }



      } catch (err) {
        this.error = err.message;
        console.log(err.message);
      }
    }
  }
}
</script>
