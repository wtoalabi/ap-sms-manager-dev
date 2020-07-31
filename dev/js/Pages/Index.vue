<template>
    <v-app id="keep">
        <div v-if="themeColorIsLoaded">
            <v-app-bar
                    :key="reloadSettings"
                    app
                    absolute
                    clipped-left
                    color="primary"
            >
                <v-app-bar-nav-icon @click="setDrawer"/>
                <span class="main-title ml-3 mr-5">SMS Manager</span>
                <v-spacer></v-spacer>
            </v-app-bar>
            <menu-list></menu-list>
            <v-main>
                <div class="mx-0 fill-height">
                    <v-card elevation="2" class="m-0 fill-height">
                        <transition
                                name="custom-classes-transition"
                                enter-active-class="animate__animated animate__fadeInUp">
                            <router-view/>
                        </transition>
                    </v-card>
                </div>
            </v-main>
        </div>
    </v-app>
</template>

<script>
    import MenuList from "@/Pages/Components/Menu/MenuList"

    export default {
        mounted() {
            this.$store.dispatch("loadMeta")
        },
        name: "Dashboard",
        props: {
            source: String,
        },
        components: {MenuList},
        data: () => ({
            drawer: null,
            items: [
                {icon: 'mdi-lightbulb-on', text: 'Notes'},
                {icon: 'mdi-cursor-pointer', text: 'Reminders'},
                {divider: true},
                {heading: 'Labels'},
                {icon: 'mdi-account-plus', text: 'Create new label'},
                {divider: true},
                {icon: 'mdi-package-down', text: 'Archive'},
                {icon: 'mdi-delete', text: 'Trash'},
                {divider: true},
                {icon: 'mdi-cog', text: 'Settings'},
                {icon: 'mdi-message', text: 'Trash'},
                {icon: 'mdi-help-circle', text: 'Help'},
                {icon: 'mdi-cellphone-link', text: 'App downloads'},
                {icon: 'mdi-keyboard', text: 'Keyboard shortcuts'},
            ],
        }),
        methods: {
            setDrawer() {
                this.$store.commit("commitMiniDrawer", !this.$store.state.miniDrawer)
            },
            setSavedSettings() {
                let colors = this.themeColors;
                this.$vuetify.theme.themes.light.primary = colors.primaryColor
                this.$vuetify.theme.themes.light.secondary = colors.secondaryColor
                this.$vuetify.theme.themes.light.success = colors.successColor
                this.$vuetify.theme.themes.light.info = colors.infoColor
                this.$vuetify.theme.themes.light.warning = colors.warningColor
                this.$vuetify.theme.themes.light.error = colors.errorColor
            }
        },

        computed: {
            themeColors() {
                return this.$store.state.settings.themeColors
            },
            themeColorIsLoaded() {
                return aps_globals._.isNotEmpty(this.$store.state.settings.themeColors.primaryColor)
            },
            reloadSettings() {
                let reload = this.$store.state.settings.reload;
                this.setSavedSettings()
                return reload;
            }
        }
    }
</script>

<style>

</style>
