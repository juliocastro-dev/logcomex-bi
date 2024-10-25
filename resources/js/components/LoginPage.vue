<template>
    <div class="login-page">
      <h1>Login</h1>
      <form @submit.prevent="login">
        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            v-model="email"
            id="email"
            required
            placeholder="Enter your email"
          />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            v-model="password"
            id="password"
            required
            placeholder="Enter your password"
          />
        </div>
        <button class="login-btn" type="submit">Login</button>
        <div v-if="error" class="error-message">
          {{ error }}
        </div>
      </form>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        email: "",
        password: "",
        error: null,
      };
    },
    methods: {
      async login() {
        try {
          // Faz a requisicao de login
          const response = await axios.post("/api/login", {
            email: this.email,
            password: this.password,
          });
  
          // Supondo que os dados do usuario e o access_token sejam retornados
          const { id, name, email, email_verified_at, created_at, updated_at, access_token } = response.data;
  
          // Armazenar os dados do usuario e o token no localStorage
          localStorage.setItem("user", JSON.stringify({ id, name, email, email_verified_at, created_at, updated_at }));
          localStorage.setItem("access_token", access_token);
  
          // Redirecionar para a pagina do dashboard
          this.$router.push({ name: 'Dashboard' });
        } catch (err) {
          this.error = "Login failed. Please check your credentials.";
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .login-page {
    position: absolute;
    width: 500px;
    height: 350px;
    top: 50%;
    left: 50%;
    margin-top: -175px;
    margin-left: -250px;
    padding: 1.5em;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 1px 1px 15px 0.5px gray;
  }
  
  .form-group {
    margin-bottom: 1em;
  }

  .login-btn {
    background-color: #3498db;
    color: white;
    padding: 10px;
    margin-top: 20px;
    width: 100%;
  }
  
  .error-message {
    color: red;
    margin-top: 1em;
  }
  </style>
  