<template>
    <div>
        <v-navigation-drawer
                height="100%"
                absolute
                app
                clipped
                v-model="drawer"
                :mini-variant.sync="miniDrawer"
                color="secondary"
        >
            <v-list dense>
                <dashboard_menu></dashboard_menu>
                <send_menu></send_menu>
                <add_menu></add_menu>
                <contacts_menu></contacts_menu>
                <groups_menu></groups_menu>
                <reports_menu></reports_menu>
                <gateways_menu></gateways_menu>
                <settings_menu></settings_menu>
                <nav_footer_menu></nav_footer_menu>
            </v-list>
        </v-navigation-drawer>

    </div>
</template>

<script>
    import dashboard_menu from "./menus/dashboard_menu"
    import contacts_menu from "./menus/contacts_menu"
    import groups_menu from "./menus/groups_menu"
    import add_menu from "./menus/add_menu"
    import settings_menu from "./menus/settings_menu"
    import reports_menu from "./menus/reports_menu"
    import gateways_menu from "./menus/gateways_menu"
    import send_menu from "./menus/send_menu"
    import nav_footer_menu from "./menus/nav_footer_menu"

    export default {
        props: {
            mobile: {
                default: true
            }
        },
        mounted() {

        },
        components: {
            dashboard_menu,
            contacts_menu,
            groups_menu,
            add_menu,
            settings_menu,
            reports_menu,
            gateways_menu,
            nav_footer_menu,
            send_menu
        },
        data() {
            return {
                dialog: false,
                drawer: true,
            }
        },
        methods: {},
        watch: {
            miniDrawer: function () {
                this.drawer = true;
            }
        },
        computed: {
            miniDrawer: {
                set: function () {

                },
                get: function () {
                    return this.$store.state.miniDrawer
                }
            }
        }
    }

</script>
