<template>
    <div class="filters-page">
      <h1>Filtros</h1>
      <div class="sidebar">
        <form @submit.prevent="filterData">
          <input v-model="filters.code" placeholder="Code" />
          <input v-model="filters.name" placeholder="Name" />
          <input v-model="filters.description" placeholder="Description" />
          <input v-model="filters.amount" type="number" placeholder="Amount" />
          <button type="submit">Filtrar</button>
        </form>
      </div>
      <div class="results">
        <ul>
          <li v-for="item in results" :key="item.id">
            <router-link :to="'/details/' + item.id">
              {{ item.name }} - {{ item.amount }}
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import api from '../axios';
  
  export default {
    data() {
      return {
        filters: {
          code: '',
          name: '',
          description: '',
          amount: null,
        },
        results: [],
      };
    },
    methods: {
      filterData() {
        api.get('/api/data/filter', { params: this.filters })
          .then(response => {
            this.results = response.data;
          })
          .catch(error => {
            console.error(error);
          });
      },
    },
  };
  </script>
  
  <style scoped>
  /* Adicione seu estilo aqui */
  </style>
  