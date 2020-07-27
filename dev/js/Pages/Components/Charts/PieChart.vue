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
            v-if="labels.length >0"
            :width="width"
            type="pie"
            :options="options"
            :series="series">
        </apexchart>
        <div v-else>No Data To Show</div>
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
