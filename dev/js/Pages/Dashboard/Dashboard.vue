<template>
    <div>
        <v-row class="ma-1">
            <v-col sm="12" md="6">
                <messages-delivery-by-month/>
            </v-col>
            <v-col sm="12" md="6">
                <contacts-addition-by-month/>
            </v-col>
        </v-row>
        <v-row class="ma-1">
            <v-col sm="12" md="6">
                <top-groups-by-contacts/>
            </v-col>
            <v-col sm="12" md="6">
                <top-gateways-by-sent-messages/>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    import ContactsAdditionByMonth from './ContactsAdditionsByMonth'
    import MessagesDeliveryByMonth from './MessagesDeliveryByMonth'
    import TopGroupsByContacts from './TopGroupsByContacts'
    import TopGatewaysBySentMessages from './TopGatewaysBySentMessages'

    export default {
        mounted() {
            this.$store.dispatch("loadMeta")
        },
        components: {ContactsAdditionByMonth, MessagesDeliveryByMonth, TopGroupsByContacts, TopGatewaysBySentMessages},
        data() {
            return {}
        },
        methods: {},
        computed: {}
    }

</script>
