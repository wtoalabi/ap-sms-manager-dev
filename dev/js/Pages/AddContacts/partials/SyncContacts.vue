<template>
    <div>
        <div>
            We can help you scan through your installed plugins and extract sms numbers that you have
            acquired through these plugins.
            <br/> For instance, if your shop is running on woocommerce, we can retrieve the phone numbers
            of all your customers.
            <br/>Not only that, we will also help you automatically reformat these numbers with the
            customers appropriate country code.
        </div>
        <div class="mt-3">
            <select-box
                    :prop-selected-i-d="1" @selected="selectedPlugin"
                    :items="plugins"
                    text="name"
                    value="id"
                    label="Pick a plugin"/>
        </div>
        <select-box
                class="mt-3"
                :prop-selected-i-d="selectedGroup"
                @selected="groupSelected"
                :items="groups" text="name" value="id"
                label="Choose Group"/>
        <div style="color: #fb0958" v-if="errorMessage">{{errorMessage}}</div>
        <div v-if="loading">
            <v-progress-linear
                    indeterminate
                    color="success"
            ></v-progress-linear>
        </div>
        <div v-else>
            <v-btn @click="scan" class="mt-2">Scan!</v-btn>
            <saved-action-buttons/>
        </div>
    </div>
</template>

<script>
    import SelectBox from "@/Pages/Components/Selectors/SelectBox";
    import SavedActionButtons from "@/Pages/AddContacts/partials/SavedActionButtons";

    export default {
        mounted() {
        },
        components: {SelectBox, SavedActionButtons},
        data() {
            return {
                selectedGroup: "",
                plugin: 1,
                errorMessage: ""
            }
        },
        methods: {
            scan() {
                if (!this.selectedGroup) {
                    this.errorMessage = "You need to select a group"
                    return;
                }
                this.$store.dispatch("syncContacts", {
                    plugin: this.plugin,
                    group: this.selectedGroup
                })
            },
            selectedPlugin(plugin) {
                this.plugin = plugin;
            },
            groupSelected(group) {
                this.selectedGroup = group;
                this.errorMessage = null
            },
        },
        computed: {
            plugins() {
                return [
                    {'id': 1, 'name': "Woocommerce"}
                ]
            },
            loading() {
                return this.$store.state.loading;
            },
            groups() {
                return this.$store.state.groups.metaList;
            },
            contactsSaved() {
                return this.$store.state.contacts.contactsSaved;
            },
        }
    }

</script>
<style scoped lang="scss">
    .saved-actions {
        margin-top: 2rem;
        justify-content: space-between;
        display: flex;
    }
</style>
