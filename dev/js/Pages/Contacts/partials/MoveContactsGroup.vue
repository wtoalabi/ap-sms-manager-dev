<template>
    <div>
        <v-btn small color="accent" @click="showDialog=true">Move To New Group</v-btn>
        <v-dialog v-model="showDialog" persistent class="dialog" max-width="520">
            <v-card height="300" class="card">
                <v-card-title class="headline dialog_title">Move Selected Contacts?</v-card-title>
                <v-card-text class="dialog_text">
                    <div>
                        <select-box @selected="groupSelected" :items="groups" text="name" value="id"
                                    label="Select New Group"/>
                        <div>{{messageText}}</div>
                    </div>
                </v-card-text>
                <v-card-actions class="dialog_buttons">
                    <v-btn small color="green darken-1" @click="showDialog=false">Cancel!</v-btn>
                    <v-btn small color="error" @click="moveGroup" :disabled="allHasSameGroup">Move
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import SelectBox from "@/Pages/Components/Selectors/SelectBox";

    export default {
        components: {SelectBox},
        data() {
            return {
                chosenGroup: "",
                allHasSameGroup: true,
                messageText: "",
                showDialog: false,
                disabled: false
            }
        },
        methods: {
            moveGroup() {
                this.showDialog = false
                this.$store.dispatch("moveContacts", [
                    this.chosenGroup.id,
                    this.selectedContacts
                ])
                this.$emit("moved")
            },
            groupSelected(selectedGroupID) {
                this.chosenGroup = this.groups.find(group => group.id === selectedGroupID)
                if (this.chosenGroup && this.chosenGroup.id !== 0) {
                    this.checkSelectedContactGroups(selectedGroupID)
                } else {
                    this.allHasSameGroup = true
                    this.messageText = "";
                }

            },
            checkSelectedContactGroups(groupID) {
                this.allHasSameGroup = this.selectedContacts.every(c => c.group.id === groupID)
                if (this.allHasSameGroup) {
                    this.messageText = `All selected contacts already have ${this.chosenGroup.name} as their group. You will have to select another group!`
                } else {
                    this.messageText = ""
                }
            }
        },
        computed: {
            groups() {
                return this.$store.state.groups.metaList
            },
            selectedContacts() {
                return this.$store.state.contacts.selectedContacts
            },
            disableButton() {
                return this.disabled
            }
        }
    }

</script>

<style scoped lang="scss">
    .card {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
    }

    .dialog_text, .dialog_title {
        display: flex;
        justify-content: center;
    }

    .dialog_buttons {
        display: flex;
        justify-content: space-between;
    }
</style>
