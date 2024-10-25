<template>
    <div class="container relative mt-20 bg-white m-auto p-6 rounded-md">
      <h1 class="title-page">Detalhes do Item</h1>
      <div v-if="item">
        <p><strong>Code:</strong> {{ item.code }}</p>
        <p><strong>Name:</strong> {{ item.name }}</p>
        <p><strong>Description:</strong> {{ item.description }}</p>
        <p><strong>Amount:</strong> {{ item.amount }}</p>
        <button type="button" @click="backDashboard()"  class="cursor-pointer bg-red-700 py-1 px-4 mt-5 text-white rounded-md hover:bg-red-500 transition-all">
          Voltar
        </button>
      </div>
      <div v-else>
        <p>Carregando detalhes...</p>
      </div>
    </div>
  </template>
  
  <script>
  import axios from '../axios';
  
  export default {
    data() {
      return {
        item: null,
      };
    },
    props: ['id'],
    mounted() {
      this.fetchDetails();
    },
    methods: {
      backDashboard() {
        this.$router.push({name: 'Dashboard'})
      },
      fetchDetails() {
        axios.get(`/api/data/details/${this.id}`)
          .then(response => {
            this.item = response.data;
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
  