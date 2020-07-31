<template>
    <div>
        <notification/>
        <div class="saved-actions" v-if="contactsSaved">
            <v-btn @click="viewAllContacts" color="primary">View All Contacts</v-btn>
            <v-btn @click="sendSMS" color="success">Start Sending SMS</v-btn>
        </div>
    </div>
</template>

<script>
    import Notification from "@/Pages/Components/Notifications/Notification";

    export default {
        components: {Notification},
        data() {
            return {}
        },
        methods: {
            sendSMS() {
                this.$router.push("/send-sms")
                this.$store.commit("toggleSavedContactsFlag")
            },
            viewAllContacts() {
                this.$router.push("/contacts/list")
                this.$store.commit("toggleSavedContactsFlag")
            },
        },
        computed: {
            contactsSaved() {
                return this.$store.state.contacts.contactsSaved;
            },
        }
    }

</script>

<style scoped lang="scss">
    .saved-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 1.3rem;
    }
</style>
