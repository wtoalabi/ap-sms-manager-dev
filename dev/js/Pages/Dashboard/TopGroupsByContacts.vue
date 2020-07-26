<template>
  <div>
    <pie-chart title="Top Groups By Contacts" :labels="labels" :series="series"></pie-chart>
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
        return Object.keys(this.stats.groups)
      },
      series(){
        return  Object.values(this.stats.groups)
      }
    }
  }

</script>
