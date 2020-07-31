<template>
    <div>
        <v-card
                class="mx-auto"
                width="mx-auto"
        >
            <v-card-title>{{title}}</v-card-title>
            <v-card-text>
                <apexchart
                        v-if="xAxis.length >0"
                        :width="width"
                        type="bar"
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
            title: {
                default: null
            },
            width: {
                default: '370',
            },
            xAxis: {
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
                    chart: {
                        id: uuid()
                    },
                    yaxis: {
                        tickAmount: 3,
                        labels: {
                            formatter: function (val) {
                                return val.toFixed(0)
                            }
                        },
                    },
                    xaxis: {
                        categories: this.xAxis
                    },
                },
            }
        },
        methods: {},
        computed: {}
    }

</script>
