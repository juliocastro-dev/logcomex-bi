<template>
    <component :is="chartComponent" :chart-data="chartData.data" :options="chartData.options" />
</template>
  
<script>
    import { Line, Bar, Pie } from 'vue-chartjs';
    import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, LineElement, CategoryScale, LinearScale } from 'chart.js';

    // Register chart.js components globally
    ChartJS.register(Title, Tooltip, Legend, BarElement, LineElement, CategoryScale, LinearScale);
    
    export default {
        props: {
        chartData: {
            type: Object,
            required: true,
        },
        },
        computed: {
        chartComponent() {
            switch (this.chartData.type) {
            case 'line':
                return Line;
            case 'bar':
                return Bar;
            // Adicione mais tipos de gráfico aqui conforme necessário
            default:
                return Line;
            }
        },
        },
    };
</script>
  