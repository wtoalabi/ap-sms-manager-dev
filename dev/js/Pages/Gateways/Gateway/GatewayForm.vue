<template>
    <div>
        <v-dialog v-model="dialog" persistent class="dialog" max-width="550">
            <v-card>
                <div v-if="errorMessage">
                    {{errorMessage}}
                </div>
                <v-card-text class="dialog_columns p-7">
                    <select-box
                            :key="reloadSelectBox"
                            :prop-selected-i-d="selectedGateway"
                            class="header_select_groups pt-2"
                            @selected="pickedGateway"
                            :items="gateway_apis"
                            text="name"
                            value="id"
                            hint="Required"
                            label="Preferred Gateway Provider"/>
                    <v-row>
                        <v-col cols="6">
                            <v-text-field
                                    v-model="gateway.name"
                                    label="Gateway Name"
                                    placeholder="Office Twillo"
                                    persistent-hint
                                    hint="Required"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                    v-model="gateway.description"
                                    label="A brief description"
                                    placeholder="e.g: My new gateway"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-text-field
                            v-model="gateway.apiKey"
                            label="API KEY, Auth Token"
                            placeholder="###"
                            hint="Required"
                            persistent-hint
                    ></v-text-field>
                    <v-text-field
                            v-model="gateway.username"
                            label="SID, API Secret or Username"
                            placeholder="###"
                            hint="Required"
                            persistent-hint
                    ></v-text-field>
                    <v-switch v-model="gateway.isDefault" label="Is this the default gateway?"></v-switch>
                </v-card-text>
                <v-card-actions class="dialog_buttons">
                    <v-btn small color="green darken-1" text @click="cancel">Cancel!
                    </v-btn>
                    <v-btn small color="error" @click="submit" :disabled="notValid">{{submitButtonText}}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import SelectBox from "@/Pages/Components/Selectors/SelectBox"

    export default {
        components: {SelectBox},
        mounted() {
            if (this.isExistingGateway) {
                this.gateway = aps_globals._.cloneDeep(this.existingGateway)
                delete this.gateway.apiKey
                delete this.gateway.username
                this.selectedGateway = this.gateway.apiName
                this.reloadSelectBox++
            }
        },
        props: ['existingGateway'],
        data() {
            return {
                errorMessage: "",
                reloadSelectBox: 0,
                selectedGateway: "",
                dialog: true,
                gateway: {
                    name: "",
                    apiKey: "",
                    apiName: "",
                    description: "",
                    isDefault: false,
                    username: ""
                }
            }
        },
        methods: {
            async pickedGateway(apiName) {
                this.gateway.apiName = apiName
            },
            submit() {
                this.$emit("submit", this.gateway)
            },
            cancel() {
                this.$emit("close")
            },
        },
        computed: {
            isExistingGateway() {
                return aps_globals._.isNotEmpty(this.existingGateway)
            },
            submitButtonText() {
                return aps_globals._.isNotEmpty(this.existingGateway) ? "Edit Gateway" : "Add Gateway"
            },
            notValid() {
                let requiredFieldsForNew = ['name', 'apiName', 'apiKey', 'username']
                if (this.isExistingGateway) {
                    return aps_globals._.isEmpty(this.gateway['name']) || aps_globals._.isEmpty(this.gateway['apiName'])
                } else {
                    return requiredFieldsForNew.some(field => aps_globals._.isEmpty(this.gateway[field]))
                }
            },
            gateway_apis() {
                return this.$store.state.gateways.gateway_apis;
            }
        }
    }

</script>

<style scoped lang="scss">

    .dialog_buttons {
        display: flex;
        justify-content: space-between;
        padding: 1.2rem;
    }

    .dialog_columns, .dialog_title {
        display: block;
    }

</style>
