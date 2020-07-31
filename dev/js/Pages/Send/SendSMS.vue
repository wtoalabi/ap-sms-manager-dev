<template>
    <div>
        <div v-if="loaded">
            <div v-if="hasContact">
                <notification/>
                <div>
                    <v-card class="card-main">
                        <v-row style="padding-top: .5rem">
                            <v-col cols="12" lg="6">
                                <select-box
                                        :chips="true"
                                        hint="We select the default gateway, if none, you have to select one."
                                        :persistent-hint="true" :multiple="false"
                                        :clearable="true"
                                        :key="reloadGatewayBox"
                                        :prop-selected-i-d="defaultGatewayID"
                                        @selected="gatewayIsSelected"
                                        :items="gateways" text="name" value="id"
                                        label="Select The Gateway API to use"/>
                            </v-col>
                            <v-col cols="12" md="6">
                                <select-box
                                        hint="Note that groups without contacts wont be shown here."
                                        :persistent-hint="true"
                                        :clearable="true" :multiple="true" :chips="true" :key="reloadGroupsBox"
                                        @clear="selectedGroup"
                                        :prop-selected-i-d="selectedGroupID" @selected="selectedGroup"
                                        :items="groups" text="name" value="id"
                                        label="Select Recipient Group(s)"/>
                            </v-col>
                        </v-row>
                        <div>
                            <manual-contact-addition @added="contactsManuallyAdded" :key="reloadManualContacts"/>
                        </div>
                        <div class="recipients_count">Total Number of Recipients: {{totalContacts}}</div>
                        <v-text-field
                                @input="validateContents"
                                v-model="form.senderID"
                                label="Sender ID"
                                outlined
                        ></v-text-field>
                        <v-textarea
                                @input="validateContents"
                                outlined
                                background-color="#F1F8E9"
                                label="Message. Note: 160 characters is 1 sms/page"
                                rows="4"
                                :hint="messageCount"
                                persistent-hint
                                v-model="form.message"/>
                        <!--<schedule :disabled="!gatewayCanSchedule" @date_time="setDateTime"/>-->
                        <v-progress-linear
                                class="progress"
                                v-if="messageIsSending"
                                indeterminate
                                color="success"
                        ></v-progress-linear>
                        <div class="submitActions">
                            <v-btn @click="reset">RESET</v-btn>
                            <v-btn @click="send" :disabled="notReadyToSend" color="primary">SEND</v-btn>
                        </div>
                    </v-card>
                </div>

            </div>
            <no-contact v-else/>
        </div>
        <v-overlay opacity="1" :value="!loaded">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
    import NoContact from '@/Pages/Components/Empties/NoContact'
    import SelectBox from "@/Pages/Components/Selectors/SelectBox"
    import ManualContactAddition from "./ManualContactAddition"
    import Schedule from "./Schedule"
    import Notification from "@/Pages/Components/Notifications/Notification"

    export default {
        mounted() {
            this.$store.dispatch("loadContacts").then(_ => {
                this.loaded = true
                if (this.gateways) {
                    this.gateways.forEach(gateway => {
                        if (gateway.isDefault) {
                            this.defaultGatewayID = gateway.id
                            this.setGateway(gateway.id)
                            this.reloadGatewayBox++
                        }
                    })
                }
            })
            this.defaultForm = aps_globals._.cloneDeep(this.form);
        },
        components: {NoContact, SelectBox, ManualContactAddition, Schedule, Notification},
        data() {
            return {
                loaded: false,
                reloadGatewayBox: 0,
                reloadManualContacts: 0,
                reloadGroupsBox: 0,
                notReadyToSend: true,
                defaultGatewayID: null,
                defaultGateway: null,
                manualContacts: [],
                selectedGateway: '',
                selectedGroupIDs: [],
                selectedGroupID: null,
                defaultForm: {},
                form: {
                    senderID: "",
                    message: "",
                    gateway: "",
                    recipients: {},
                    time: ""
                }
            }
        },
        methods: {
            contactsManuallyAdded(contacts) {
                this.manualContacts = contacts.numbers;
                this.notReadyToSend = contacts.hasError;
                this.form.recipients.manual = contacts.numbers;
            },
            selectedGroup(groups) {
                this.selectedGroupIDs = groups;
                if (aps_globals._.isNotEmpty(groups)) {
                    this.form.recipients.groups = groups
                } else {
                    delete this.form.recipients.groups
                }
                this.validateContents()
            },
            gatewayIsSelected(gatewayID) {
                this.setGateway(gatewayID)
                this.validateContents()
            },
            send() {
                this.$store.dispatch("sendSMS", this.form)
            },
            reset() {
                this.form = aps_globals._.cloneDeep(this.defaultForm)
                this.selectedGroupIDs = null
                this.reloadGroupsBox++;
                this.reloadManualContacts++
            },
            validateContents() {
                let fields = ['gateway', 'recipients', 'senderID', 'message'];
                this.notReadyToSend = fields.some((field) => {
                    return aps_globals._.isNotFilled(this.form[field]);
                })
            },
            setGateway(gatewayID) {
                this.selectedGateway = this.gateways.find(gateway => gatewayID === gateway.id);
                this.form.gateway = gatewayID;
            },
            setDateTime(date_time) {
                this.form.time = date_time;
            },

        },
        watch: {
            messageIsSending: {
                handler() {
                    this.reset()
                    this.$store.commit("toggle_message_is_sending", false);
                }
            },

        }
        ,
        computed: {
            meta() {
                return aps_globals._.isNotEmpty(this.$store.state.stats)
            },
            contacts() {
                return this.$store.state.contacts.list
            }
            ,
            hasContact() {
                return aps_globals._.isNotEmpty(this.contacts)
            }
            ,
            groups() {
                let groups = this.$store.state.groups.metaList
                let filteredGroups = groups.filter(group => group.contacts >= 1);
                return filteredGroups.map(group => {
                    if (!group.name.includes("(")) {
                        group.name = `${group.name} (${group.contacts})`
                    }
                    return group;
                })
            }
            ,
            gateways() {
                return this.$store.state.gateways.metaList
            },
            totalContacts() {
                let count = 0;
                for (let index = 0; index < this.selectedGroupIDs.length; index++) {
                    let groupID = this.selectedGroupIDs[index];
                    let group = this.groups.find(group => group.id === groupID);
                    count += group.contacts
                }
                if (this.manualContacts) {
                    count += this.manualContacts.length
                }
                return count;
            },
            messageCount() {
                let perPage = 160;
                let length = this.form.message.length;
                let page = Math.ceil(length / perPage);
                return `${length}/${page} page${page > 1 ? 's' : ''}`;
            },
            gateway_apis() {
                return this.$store.state.gateways.gateway_apis;
            }
            ,
            selectedGatewayMetaInfo() {
                if (this.form.gateway) {
                    return this.gateway_apis.find(gateway => gateway.id === this.selectedGateway.apiName)
                }
                return null
            }
            ,
            gatewayCanSchedule() {
                if (this.selectedGatewayMetaInfo) {
                    return this.selectedGatewayMetaInfo.canSchedule
                }
                return false;
            }
            ,
            loading() {
                return this.$store.state.loading;
            },
            messageIsSending() {
                return this.$store.state.messages.isSending;
            },
        }
    }

</script>
<style lang="scss" scoped>
    .col {
        padding-top: 0 !important;
    }

    .card-main {
        padding: 0 1rem;
        margin-top: -.5rem;
    }

    .submitActions {
        padding: 1rem;
        display: flex;
        justify-content: space-between;
    }

    .recipients_count {
        margin-bottom: 17px;
    }

    .progress {
        margin-top: 5px;
        margin-bottom: 20px;
    }
</style>
