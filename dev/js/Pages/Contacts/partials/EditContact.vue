<template>
    <div>
        <v-icon
                small
                class="mr-2"
                @click="editDialog=true"
        >
            mdi-pencil
        </v-icon>

        <v-dialog v-model="editDialog" persistent class="dialog" max-width="420" v-if="contact">
            <v-card>
                <v-card-text class="dialog_text p-7">
                    <v-text-field
                            class="my-6"
                            v-model="contact.number"
                            label="Contact's Number"
                    ></v-text-field>
                    <select-box :prop-selected-i-d="contact.group.id" @selected="selectedGroup"
                                :items="groups" text="name" value="id"
                                label="Choose Group"/>
                </v-card-text>
                <v-card-actions class="dialog_buttons">
                    <v-btn small color="green darken-1" text @click="editDialog=false">Cancel!
                    </v-btn>
                    <v-btn small color="error" @click="editContact">Edit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import SelectBox from "@/Pages/Components/Selectors/SelectBox"

    export default {
        mounted() {
            this.contact = this.propContact
        },
        props: ['propContact'],
        components: {SelectBox},
        data() {
            return {
                editDialog: false,
                contact: null
            }
        },
        methods: {
            editContact() {
                this.$store.dispatch("updateContact", this.contact)
                this.editDialog = false
            },
            selectedGroup(groupID) {
                this.contact.group_id = groupID
            },
        },
        computed: {
            groups() {
                return this.$store.state.groups.list.filter(g => g.id >= 1)
            },
        }
    }

</script>
<style scoped lang="scss">
    .dialog_text, .dialog_title {
        display: flex;
        justify-content: center;
        flex-direction: column;
    }

    .dialog_text {
        padding: 1.4rem;
    }

    .dialog_buttons {
        display: flex;
        justify-content: space-between;
    }
</style>
