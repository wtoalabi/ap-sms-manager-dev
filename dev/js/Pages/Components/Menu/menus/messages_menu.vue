<template>
    <div>
        <v-list-item
                key="contacts"
                to="/contacts/list"
                link
        >
            <v-list-item-action>
                <v-icon>mdi-account-multiple-plus</v-icon>
            </v-list-item-action>
            <v-list-item-content>
                <v-list-item-title>
                    Contacts
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        methods: {},
        computed: {}
    }

</script>
