<template>
    <div>
        <area-chart title="Contact Additions By Month" :x-axis="xaxis" :series="series"></area-chart>
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
            stats() {
                return this.$store.state.stats
            },
            xaxis() {
                return Object.keys(this.stats.contacts)
            },
            series() {
                return [{
                    name: 'Added Contacts',
                    data: Object.values(this.stats.contacts)
                }]
            }
        }
    }

</script>
