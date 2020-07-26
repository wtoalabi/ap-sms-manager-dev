<template>
  <div>
    <pie-chart title="Top Gateways By Sent Messages" :labels="labels" :series="series"></pie-chart>
  </div>
</template>

<script>
  import PieChart from '@/Pages/Components/Charts/PieChart'
  export default {
    components: {PieChart},
    data() {
      return {}
    },
    methods: {},
    computed: {
      stats(){
        return this.$store.state.stats
      },
      labels(){
        return Object.keys(this.stats.gateways)
      },
      series(){
        return  Object.values(this.stats.gateways)
      }
    }
  }

</script>
