<template>
    <div>
        <contacts-menu/>
        <div class="header">
            <div class="text">
                <v-text-field
                        clearable
                        @clear="resetQueries"
                        class="header_text_field"
                        v-model="searchText"
                        @input="searchContacts"
                        label="Search Contacts By Number..."
                ></v-text-field>
            </div>
            <div class="selectors">
                <select-box :key="reloadSelectBox" :prop-selected-i-d="selectedGroupID" @selected="selectedGroup"
                            :items="groups" text="name" value="id"
                            label="Filter By Group"/>
                <select-box @selected="selectedContactSource" :items="contactSources" text="name"
                            label="Filter By Contact Source"/>
            </div>
        </div>
        <v-data-table
                loading-text="Loading Contacts..."
                @toggle-select-all="selectAll"
                v-model="selectedContacts"
                :headers="headers"
                :items-per-page="itemsPerPage"
                :server-items-length="rowsNumber"
                item-key="id"
                show-select
                class="elevation-1"
                @input="select"
                :options.sync="options"
                :loading="loading"
                must-sort
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :items="contacts"
                no-data-text="No Contact Found..."
        >
            <template v-slot:top>
                <div v-if="selectedContacts.length >=1">
                    <div class="selected_options">
                        <move-contacts-group @moved="selectedContacts=[]"/>
                        <v-btn color="error" small @click="showDeleteDialog=true">Delete Selected Contacts
                        </v-btn>
                    </div>
                </div>
                <notification/>
            </template>
            <template v-slot:item.actions="{ item }">
        <span style="display: flex;justify-content: flex-end;align-items: center;">
          <edit-contact :prop-contact="item"/>
          <v-icon small @click="deleteSingleContact(item)">
            mdi-delete
          </v-icon>
        </span>
            </template>
            <template v-slot:item.group="{ item }">
                {{item.group.name}}
            </template>
        </v-data-table>
        <v-dialog v-model="showDeleteDialog" persistent class="dialog" max-width="420">
            <v-card>
                <v-card-title class="headline dialog_title">Are you sure?</v-card-title>
                <v-card-text class="dialog_text">Note that this action is not reversible!
                </v-card-text>
                <v-card-actions class="dialog_buttons">
                    <v-btn small color="green darken-1" @click="showDeleteDialog=false">No...Please Cancel!
                    </v-btn>
                    <v-btn small color="error" text @click="deleteContacts">Yes Go Ahead & Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
    import ContactsMenu from "./partials/ContactsMenu"
    import EditContact from "./partials/EditContact"
    import MoveContactsGroup from "./partials/MoveContactsGroup"
    import SelectBox from "@/Pages/Components/Selectors/SelectBox"
    import Notification from "@/Pages/Components/Notifications/Notification"

    export default {
        mounted() {
            let groupID = Number.parseInt(this.$route.query.group)
            if (groupID) {
                this.selectedGroup(groupID)
                this.selectedGroupID = groupID
                this.reloadSelectBox++
            }
        },
        components: {EditContact, MoveContactsGroup, Notification, ContactsMenu, SelectBox},
        data() {
            return {
                reloadSelectBox: 0,
                selectedGroupID: null,
                showDeleteDialog: false,
                options: {},
                sortBy: ['number'],
                sortDesc: false,
                selectedContacts: [],
                searchText: '',
                itemsPerPage: 10,
                headers: [
                    {
                        text: 'Contact',
                        align: 'start',
                        sortable: true,
                        value: 'number',
                    },
                    {text: 'Group', value: 'group', sortable: false},
                    {text: 'Source', value: 'source'},
                    {text: '', value: 'actions', sortable: false, align: 'end',},
                ],
            }
        },
        watch: {
            options: {
                handler() {
                    this.selectedContacts = []
                    this.itemsPerPage = this.items_per_page
                    this.$store.commit("setQueryOptions", this.options);
                    this.loadContacts()
                }
            }
        },
        methods: {
            async selectedGroup(groupID) {
                if (groupID === 0) {
                    await this.resetQueries()
                } else {
                    this.$store.commit("resetPageNumber")
                    this.$store.commit("setQueryFilterByColumn", ['group_id', groupID])
                }
                this.loadContacts()
            },
            searchContacts() {
                aps_globals._.debounce(async () => {
                    this.$store.commit("resetPageNumber")
                    this.$store.commit("setQuerySearchArray", ['number', this.searchText])
                    this.loadContacts();
                })
            },
            select(items) {
                this.selectedContacts = items;
                this.$store.commit("updatedSelectedContacts", this.selectedContacts)
            },
            loadContacts() {
                this.$store.dispatch("loadContacts");
            },
            selectAllContacts() {
                this.$store.commit("selectAllContacts", true)
            },
            selectAll(selected) {
                this.allSelected = selected.value
            },
            async resetQueries() {
                await this.$store.commit("resetQueryState");
            },
            async selectedContactSource(source) {
                if (source.name === 'None') {
                    await this.resetQueries()
                } else {
                    this.$store.commit("resetPageNumber")
                    this.$store.commit("setQueryFilterByColumn", ['source', source])
                }
                this.loadContacts()
            },
            deleteContacts() {
                this.$store.dispatch("deleteContacts", this.selectedContacts)
                this.showDeleteDialog = false;
                this.selectedContacts = []
            },
            deleteSingleContact(contact) {
                this.showDeleteDialog = true
                this.selectedContacts = [contact]
            }
        },
        computed: {
            contacts() {
                return this.$store.state.contacts.list
            },
            loading() {
                return this.$store.state.loading;
            }
            ,
            rowsNumber() {
                return this.$store.state.contacts.rowsNumber
            }
            ,
            items_per_page() {
                return this.$store.state.queries.pagination.queryPagination.itemsPerPage
            }
            ,
            displayTop() {
                return aps_globals._.isNotEmpty(this.selectedContacts);
            }
            ,
            groups() {
                return this.$store.state.groups.metaList
            },
            contactSources() {
                return this.$store.state.contacts.contactSources
            },
        }
    }

</script>

<style scoped lang="scss">
    .dialog_text, .dialog_title {
        display: flex;
        justify-content: center;
    }

    .dialog_buttons {
        display: flex;
        justify-content: space-between;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;

        .text {
            margin-top: 5px;
            flex: 2;
        }

        .selectors {
            flex: 3;
            display: flex;
            justify-content: space-around;
        }

        .header_select, .header_text_field {
            margin: 10px;
        }
    }

    .selected_options {
        display: flex;
        justify-content: space-between;
        padding: 0 1rem;
    }
</style>

