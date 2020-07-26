<template>
  <div>
    <area-chart title="Message Delivery By Month" :x-axis="xaxis" :series="series"></area-chart>
  </div>
</template>

<script>
  import AreaChart from '@/Pages/Components/Charts/AreaChart'
  export default {
    components: {AreaChart},
    data() {
      return {}
    },
    methods: {},
    computed: {
      stats(){
        return this.$store.state.stats
      },
      xaxis(){
        return Object.keys(this.stats.messages)
      },
      series(){
        return  [{
          name: 'Messages Sent',
          data: Object.values(this.stats.messages)
        }]
      }
    }
  }

</script>
