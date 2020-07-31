<template>
    <div>
        <div class="header">
            <div class="text">
                <div class="top">
                    <div class="add_new">
                        <v-btn color="primary" @click="addDialog=true">
                            <v-icon left>mdi-plus</v-icon>
                            Add New Group
                        </v-btn>
                    </div>
                    <v-text-field
                            clearable
                            @clear="resetQueries"
                            class="header_text_field"
                            v-model="searchText"
                            @input="searchGroups"
                            label="Search Group By Name..."
                    ></v-text-field>
                    <select-box class="header_select_groups" @selected="filteredGroup" :items="metaGroups"
                                text="name" value="id"
                                label="Filter By Name"/>
                </div>
            </div>
        </div>
        <v-data-table
                loading-text="Loading Groups..."
                selectable-key="isSelectedAble"
                @toggle-select-all="toggleAllGroups"
                v-model="selectedGroups"
                :headers="headers"
                :items="groups"
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
                no-data-text="No Group Found..."
        >
            <template v-slot:top>
                <div v-if="selectedGroups.length >=1">
                    <div class="selected_options">
                        <v-btn color="error" small @click="showDeleteDialog=true">Delete Selected Groups
                        </v-btn>
                    </div>
                </div>
                <notification/>
            </template>
            <template v-slot:item.contacts_count="{item}">
                <a @click.prevent="goToContacts(item)">
                    {{item.contacts}}
                </a>
            </template>
            <template v-slot:item.actions="{ item }">
        <span style="display: flex;justify-content: flex-end;align-items: center;">
          <v-icon small @click="editSingleGroup(item)" style="margin:20px" :disabled="item.id===1">
            mdi-pencil
          </v-icon>
          <v-icon small @click="deleteSingleGroup(item)" :disabled="item.id===1">
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
                <v-card-text class="dialog_text">Note that this action is not reversible and that deleted contact's
                    group would be moved to the Default Group.
                </v-card-text>
                <v-card-actions class="dialog_buttons">
                    <v-btn small color="green darken-1" @click="showDeleteDialog=false">No...Please Cancel!
                    </v-btn>
                    <v-btn small color="error" text @click="deleteGroup">Yes Go Ahead & Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="editDialog" persistent class="dialog" max-width="420">
            <v-card>
                <v-card-text class="dialog_text p-7">
                    <v-text-field
                            class="my-6"
                            v-model="selectedGroup.name"
                            label="Group Name"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions class="dialog_buttons">
                    <v-btn small color="green darken-1" text @click="editDialog=false">Cancel!
                    </v-btn>
                    <v-btn small color="error" @click="edit">Edit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="addDialog" persistent class="dialog" max-width="420">
            <v-card>
                <v-card-text class="dialog_text p-7">
                    <v-text-field
                            class="my-6"
                            v-model="group.name"
                            label="Group Name"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions class="dialog_buttons">
                    <v-btn small color="green darken-1" text @click="addDialog=false">Cancel!
                    </v-btn>
                    <v-btn small color="error" @click="addGroup">Create</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import SelectBox from "@/Pages/Components/Selectors/SelectBox"
    import Notification from "@/Pages/Components/Notifications/Notification"

    export default {
        mounted() {

        },
        components: {Notification, SelectBox},
        data() {
            return {
                group: {
                    name: ""
                },
                addDialog: false,
                selectedGroup: "",
                editDialog: false,
                showDeleteDialog: false,
                options: {},
                sortBy: ['name'],
                sortDesc: false,
                selectedGroups: [],
                searchText: '',
                itemsPerPage: 10,
                headers: [
                    {
                        text: 'Group',
                        align: 'start',
                        sortable: true,
                        value: 'name',
                    },
                    {
                        text: 'Contacts',
                        align: 'start',
                        sortable: true,
                        value: 'contacts_count',
                    },
                    {text: '', value: 'actions', sortable: false, align: 'end',},
                ],
            }
        },
        watch: {
            options: {
                handler() {
                    this.selectedGroup = []
                    this.itemsPerPage = this.items_per_page
                    this.$store.commit("setQueryOptions", this.options);
                    this.loadGroups()
                }
            }
        },
        methods: {
            async filteredGroup(groupID) {
                if (groupID === 0) {
                    await this.resetQueries()
                } else {
                    this.$store.commit("resetPageNumber")
                    this.$store.commit("setQueryFilterByColumn", ['id', groupID])
                }
                this.loadGroups()
            },
            searchGroups() {
                aps_globals._.debounce(async () => {
                    this.$store.commit("resetPageNumber")
                    this.$store.commit("setQuerySearchArray", ['name', this.searchText])
                    this.loadGroups();
                })
            },
            select(items) {
                this.selectedGroups = items;
            },
            loadGroups() {
                this.$store.dispatch("loadGroups");
            },
            toggleAllGroups(selected) {
                this.allSelected = selected.value
            },
            async resetQueries() {
                await this.$store.commit("resetQueryState");
            },
            addGroup() {
                this.addDialog = false;
                this.$store.dispatch("addGroup", this.group)
            },
            editSingleGroup(group) {
                this.selectedGroup = aps_globals._.cloneDeep(group)
                this.editDialog = true;
            },
            edit() {
                this.editDialog = false
                this.$store.dispatch("updateGroup", this.selectedGroup)
            },
            deleteSingleGroup(group) {
                this.showDeleteDialog = true
                this.selectedGroups = [group]
            },
            deleteGroup() {
                this.$store.dispatch("deleteGroup", this.selectedGroups)
                this.showDeleteDialog = false;
                this.selectedGroup = [];
                this.selectedGroups = [];
            },
            goToContacts(group) {
                this.$router.push(`/contacts/list?group=${group.id}`)
            },
        },
        computed: {
            loading() {
                return this.$store.state.loading;
            }
            ,
            rowsNumber() {
                return this.$store.state.groups.rowsNumber
            }
            ,
            items_per_page() {
                return this.$store.state.queries.pagination.queryPagination.itemsPerPage
            }
            ,
            displayTop() {
                return aps_globals._.isNotEmpty(this.selectedGroup);
            },
            groups() {
                return this.$store.state.groups.list.map(function (group) {
                    group.isSelectedAble = group.name !== "Default Group";
                    return group;
                })
            },
            metaGroups() {
                return this.$store.state.groups.metaList
            },
        }
    }

</script>

<style scoped lang="scss">
    .top {
        display: flex;
        justify-content: space-between;
        align-items: center;

        .add_new {
            flex: 1;
            margin-top: -10px;
        }

        .header_text_field {
            flex: 2;
            margin: 0 30px;
        }

        .header_select_groups {
            flex: 1;
        }
    }

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
        margin: 0 1rem;
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
    }

    .selected_options {
        display: flex;
        justify-content: space-between;
        padding: 0 1rem;
    }
</style>

