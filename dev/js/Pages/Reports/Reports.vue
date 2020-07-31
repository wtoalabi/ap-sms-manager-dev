<template>
    <div>
        <div class="header">
            <div class="text">
                <div class="top">
                    <v-text-field
                            clearable
                            @clear="resetQueries"
                            class="header_text_field"
                            v-model="searchText"
                            @input="searchReports"
                            label="Search for Message..."
                    ></v-text-field>
                </div>
            </div>
        </div>
        <v-data-table
                loading-text="Loading Reports..."
                :headers="headers"
                :items="reports"
                :items-per-page="itemsPerPage"
                :server-items-length="rowsNumber"
                item-key="id"
                class="elevation-1"
                :options.sync="options"
                :loading="loading"
                must-sort
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                no-data-text="No Report Found..."
        >
            <template v-slot:item.created_at="{item}">
                <a href="" @click.prevent="select(item)">{{item.created_at}}</a>
            </template>
            <template v-slot:item.message="{item}">
                {{item.message|shorten(30)}}
            </template>
            <template v-slot:item.status="{item}">
                <div v-if="item.status==='error'">
                    <v-icon
                            color="error">mdi-alert-circle
                    </v-icon>
                </div>
                <div v-else>
                    <v-icon color="success">mdi-checkbox-marked-circle-outline</v-icon>
                </div>
            </template>
        </v-data-table>
        <v-dialog
                v-model="showDialog"
                class="dialog"
                max-width="760"
        >
            <v-card style="padding: 1.5rem;max-height: 750px">
                <v-card-text class="dialog_text">
                    <div class="row">
                        <div><span class="title">Gateway API</span>: {{selectedReport.gateway}}</div>
                        <div><span class="title">Gateway Name</span>: {{selectedReport.gatewayName}}</div>
                    </div>
                    <div class="row">
                        <div>
                            <span class="title">Sender ID</span>: {{selectedReport.senderID}}
                        </div>
                        <div>
                            <span class="title">Total Recipients</span>: {{selectedReport.recipientsCount}}
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <span class="title">Status</span>:
                            <span v-if="selectedReport.status==='error'">
                ERROR
                <v-icon
                        color="error">mdi-alert-circle
                </v-icon>
              </span>
                            <span v-else>
                SUCCESS
                <v-icon color="success">mdi-checkbox-marked-circle-outline</v-icon>
              </span>
                        </div>
                        <div>
                            <span class="title">Response </span>: {{selectedReport.responseMessage}}
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <span class="title">Groups </span>: {{selectedReport.groups}}
                        </div>
                        <div>
                            <span class="title">ScheduleTime</span>: {{selectedReport.scheduleTime}}
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <span class="title">Message</span>: {{selectedReport.message | shorten(1800)}}
                        </div>
                        <div>
                            <span class="title">{{messageCount}}</span>
                        </div>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import SelectBox from "@/Pages/Components/Selectors/SelectBox"

    export default {
        mounted() {
        },
        components: {SelectBox},
        data() {
            return {
                showDialog: false,
                selectedReport: "",
                options: {},
                sortBy: ['id'],
                sortDesc: false,
                searchText: '',
                itemsPerPage: 10,
                headers: [
                    {
                        text: 'Date',
                        align: 'start',
                        sortable: true,
                        value: 'created_at',
                    }, {
                        text: 'Sender',
                        align: 'start',
                        sortable: true,
                        value: 'senderID',
                    },
                    {
                        text: 'Message',
                        align: 'start',
                        sortable: true,
                        value: 'message',
                    }, {
                        text: 'Total Recipients',
                        align: 'center',
                        sortable: true,
                        value: 'recipientsCount',
                    }, {
                        text: 'Status',
                        align: 'start',
                        sortable: true,
                        value: 'status',
                    },
                ],
            }
        },

        methods: {
            searchReports() {
                aps_globals._.debounce(async () => {
                    this.$store.commit("setQuerySearchArray", ['message', this.searchText])
                    this.loadReports();
                })
            },
            select(item) {
                this.selectedReport = item;
                this.showDialog = true
            },
            loadReports() {
                this.$store.dispatch("loadReports");
            },

            async resetQueries() {
                await this.$store.commit("resetQueryState");
            },
        },
        watch: {
            options: {
                handler() {
                    this.selectedReport = []
                    this.itemsPerPage = this.items_per_page
                    this.$store.commit("setQueryOptions", this.options);
                    this.loadReports()
                }
            }
        },
        computed: {
            loading() {
                return this.$store.state.loading;
            }
            ,
            rowsNumber() {
                return this.$store.state.reports.rowsNumber
            }
            ,
            items_per_page() {
                return this.$store.state.queries.pagination.queryPagination.itemsPerPage
            }
            ,
            displayTop() {
                return aps_globals._.isNotEmpty(this.selectedReport);
            },
            reports() {
                return this.$store.state.reports.list
            },
            messageCount() {
                if (this.selectedReport.message) {

                    let perPage = 160;
                    let length = this.selectedReport.message.length;
                    let page = Math.ceil(length / perPage);
                    return `${length}/${page} page${page > 1 ? 's' : ''}`;
                }
                return null
            },
        }
    }

</script>

<style scoped lang="scss">
    .top {
        display: flex;
        justify-content: space-between;
        align-items: center;


        .header_text_field {
            flex: 2;
        }

        .header_select_reports {
            flex: 1;
        }
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
    }

    .selected_options {
        display: flex;
        justify-content: space-between;
        padding: 0 1rem;
    }

    .dialog_text, .dialog_title {
        display: flex;
        justify-content: center;
        flex-direction: column;
        height: 100%;

        .row {
            display: flex;
            width: 100%;
            justify-content: space-between;
            height: 100%;
        }

        .title {
            color: black;
            font-size: 15px !important;
        }
    }
</style>

