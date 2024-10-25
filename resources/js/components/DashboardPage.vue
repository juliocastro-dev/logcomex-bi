<template>
  <div class="dashboard-page">
    <!-- <h1 class="title-page">Dashboard</h1> -->
    <div class="dashboard-container">
      <aside class="sidebar">
        <h2 class="text-xl">Filtros</h2>
        <form @submit.prevent="applyFilters">
          <label for="code">Code:</label>
          <input v-model="filters.code" id="code" placeholder="Digite o código" />

          <label for="name">Name:</label>
          <input v-model="filters.name" id="name" placeholder="Digite o nome" />

          <label for="description">Description:</label>
          <input v-model="filters.description" id="description" placeholder="Digite a descrição" />

          <label for="amount">Amount:</label>
          <input v-model="filters.amount" type="number" id="amount" placeholder="Digite o valor" />

          <button type="submit">Aplicar Filtros</button>
          <button type="button" @click="resetFilters">Resetar Filtros</button>
        </form>
      </aside>
      <div class="charts">
        <div v-for="(chartData, index) in chartDatas" :key="index" class="chart-container">
          <component :is="chartData.type" :data="chartData.data" :options="chartData.options" :id="'chart-' + index"></component>
        </div>
      </div>
      <div class="item-list">
        <h2 class="text-xl">Top Items</h2>
        <ul>
          <li v-for="item in topItems" :key="item.id" @click="goToDetails(item.id)">
            <strong>{{ item.name }}</strong>: {{ item.amount }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  LineElement,
  CategoryScale,
  LinearScale,
  ArcElement,
  RadialLinearScale,
  PointElement,
  LineController,
} from 'chart.js';
import { Bar, Line, Pie, Radar, Scatter } from 'vue-chartjs';
import api from '../axios';

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  LineElement,
  ArcElement,
  CategoryScale,
  LinearScale,
  RadialLinearScale,
  PointElement,
  LineController
);

export default {
  components: {
    Bar,
    Line,
    Pie,
    Radar,
    Scatter,
  },
  data() {
    return {
      chartDatas: [],
      topItems: [],
      filters: {
        code: '',
        name: '',
        description: '',
        amount: ''
      },
    };
  },
  mounted() {
    this.fetchDashboardData();
  },
  methods: {
    fetchDashboardData() {
      api.get('/api/data/dashboard', { params: this.getFilterParams() })
        .then(response => {
          this.chartDatas = this.buildCharts(response.data);
          this.topItems = response.data.top_names;
        })
        .catch(error => {
          console.error(error);
        });
    },
    getFilterParams() {
      return Object.fromEntries(
        Object.entries(this.filters).filter(([key, value]) => value !== null && value !== '')
      );
    },
    applyFilters() {
      this.fetchDashboardData();
    },
    resetFilters() {
      this.filters = {
        code: '',
        name: '',
        description: '',
        amount: ''
      };
      this.fetchDashboardData();
    },
    goToDetails(id) {
      this.$router.push({ name: 'Details', params: { id } });
    },
    buildCharts(data) {
      return [
        {
          type: Bar,
          data: this.formatBarChartData(data.amount_distribution),
          options: { responsive: true, maintainAspectRatio: false },
        },
        {
          type: Line,
          data: this.formatLineChartData(data.amount_distribution),
          options: { responsive: true, maintainAspectRatio: false },
        },
        {
          type: Pie,
          data: this.formatPieChartData(data.amount_distribution),
          options: { responsive: true, maintainAspectRatio: false },
        },
        {
          type: Radar,
          data: this.formatRadarChartData(data.amount_distribution),
          options: { responsive: true, maintainAspectRatio: false },
        },
        {
          type: Scatter,
          data: this.formatScatterChartData(data.amount_distribution),
          options: { responsive: true, maintainAspectRatio: false },
        },
      ];
    },
    formatBarChartData(data) {
      return {
        labels: data.map(item => item.amount),
        datasets: [
          {
            label: 'Distribuição de Amount',
            backgroundColor: '#3498db',
            data: data.map(item => item.count),
          },
        ],
      };
    },
    formatLineChartData(data) {
      return {
        labels: data.map(item => item.amount),
        datasets: [
          {
            label: 'Distribuição de Amount',
            borderColor: '#f87979',
            backgroundColor: 'rgba(248, 121, 121, 0.2)',
            data: data.map(item => item.count),
          },
        ],
      };
    },
    formatPieChartData(data) {
      return {
        labels: data.map(item => item.amount),
        datasets: [
          {
            label: 'Distribuição de Amount',
            backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56'],
            data: data.map(item => item.count),
          },
        ],
      };
    },
    formatRadarChartData(data) {
      return {
        labels: data.map(item => item.amount),
        datasets: [
          {
            label: 'Distribuição de Amount',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            data: data.map(item => item.count),
          },
        ],
      };
    },
    formatScatterChartData(data) {
      return {
        datasets: [
          {
            label: 'Distribuição de Amount',
            backgroundColor: '#36a2eb',
            data: data.map(item => ({ x: item.amount, y: item.count })),
          },
        ],
      };
    },
  },
};
</script>

<style scoped>
  .dashboard-container {
    display: flex;
  }

  .charts {
    padding: 10px;
  }

  .sidebar {
    width: 250px;
    padding: 20px;
    background-color: #f4f4f4;
    border-right: 1px solid #ddd;
  }

  .sidebar h2 {
    margin-bottom: 20px;
  }

  .sidebar form label {
    display: block;
    margin-top: 10px;
  }

  .sidebar form input,
  .sidebar form button {
    width: 100%;
    padding: 8px;
  }

  .sidebar form button {
    background-color: #3498db;
    color: white;
    border: none;
    cursor: pointer;
    margin-top: 20px;
  }

  .sidebar form button[type="button"] {
    background-color: #e74c3c;
    margin-top: 10px;
  }

  .chart-container {
    width: 500px;
    height: 300px;
    margin: 20px;
  }

  .item-list {
    margin-top: 30px;
  }
  .item-list ul {
    list-style-type: none;
    padding: 0;
  }
  .item-list li {
    cursor: pointer;
    padding: 10px 0;
    font-size: 18px;
    color: #3498db;
  }
  .item-list li:hover {
    text-decoration: underline;
  }
</style>
