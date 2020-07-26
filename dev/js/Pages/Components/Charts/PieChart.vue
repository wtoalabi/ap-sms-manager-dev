<template>
  <div>
    <v-card
        height="300"
        class="mx-auto"
        width="mx-auto"
    >
      <v-card-title>{{title}}</v-card-title>
      <v-card-text>
        <apexchart
            :width="width"
            type="pie"
            :options="options"
            :series="series">
        </apexchart>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
  export default {
    props: {
      title:{
        default: null
      },
      width: {
        default: '370',
      },
      labels: {
        default: () => []
      },
      series: {
        default: () => {
        }
      }
    },
    data() {
      return {
        options: {
          responsive: [{
            breakpoint: 480,
            options: {
              chart: {
                width: 200
              },
              legend: {
                position: 'bottom'
              }
            }
          }],
          chart: {
            id: uuid(),
            type: 'pie',
            width: this.width
          },
          labels: this.labels
        },
      }
    },
    methods: {},
    computed: {}
  }

</script>
