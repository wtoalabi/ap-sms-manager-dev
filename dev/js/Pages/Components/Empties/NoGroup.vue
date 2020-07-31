<template>
    <div>
        <v-alert
                text
                prominent
                type="error"
        >
            <v-row align="center">
                <v-col class="grow" style="text-align: center">You are yet to register a single Group. <br/>Your
                    contacts need to have groups before you can start sending messages.
                </v-col>
                <v-col class="shrink">
                    <v-btn color="error">Click to create One!</v-btn>
                </v-col>
            </v-row>
        </v-alert>
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
