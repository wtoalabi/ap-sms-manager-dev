<template>
    <div>
        <add-options @tabSelected="tabSelect"/>
        <v-card elevation="1" class="card">
            <div class="mt-0">
                <upload-contacts v-if="activeTab==='uploadContacts'"/>
                <input-contacts v-if="activeTab==='inputContacts'"/>
                <sync-contacts v-if="activeTab==='syncContacts'"/>
            </div>
        </v-card>
    </div>
</template>

<script>
    import AddOptions from "./partials/AddOptions"
    import UploadContacts from "./partials/UploadContacts"
    import SyncContacts from "./partials/SyncContacts"
    import InputContacts from "./partials/InputContacts"
    import NoGroup from "@/Pages/Components/Empties/NoGroup"

    export default {
        components: {AddOptions, SyncContacts, InputContacts, UploadContacts, NoGroup},
        mounted() {
            let tab = Object.keys(this.$route.query)[0];
            if (tab) {
                this.activeTab = tab;
            } else {
                this.activeTab = "uploadContacts"
            }
        },
        data() {
            return {
                tabs: 0,
                activeTab: ""
            }
        },
        methods: {
            tabSelect(tab) {
                this.activeTab = tab
                this.tab++
            },
        },
        computed: {
            groups() {
                return this.$store.state.groups.filter(g => g.id >= 1)
            },
        }
    }

</script>
<style lang="scss" scoped>
    .card {
        padding: 1rem;
        background-color: #e6f3fd5c;
        margin: 0;
    }
</style>
