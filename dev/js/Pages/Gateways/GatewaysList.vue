<template>
  <div>
    <div class="header">
      <div class="text">
        <div class="top">
          <div class="add_new">
            <v-btn color="primary" @click="addDialog=true">
              <v-icon left>mdi-plus</v-icon>
              Add New Gateway
            </v-btn>
          </div>
          <v-text-field
              clearable
              @clear="resetQueries"
              class="header_text_field"
              v-model="searchText"
              @input="searchGateways"
              label="Search Gateway By Name..."
          ></v-text-field>
        </div>
      </div>
    </div>
    <v-data-table
        id="gatewayTables"
        loading-text="Loading Gateways..."
        @toggle-select-all="toggleAllGateways"
        v-model="selectedGateways"
        :headers="headers"
        :items="gateways"
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
        no-data-text="No Gateway Found..."
    >
      <template v-slot:top>
        <div v-if="selectedGateway.length >=1">
          <div class="selected_options">
            <v-btn color="error" small @click="showDeleteDialog=true">Delete Selected Gateways
            </v-btn>
          </div>
        </div>
        <notification/>
      </template>
      <template v-slot:item.name="{item}">
        <v-icon x-small :color="defaultColor(item.isDefault)">mdi-circle</v-icon>
        {{item.name | shorten(10)}}
      </template>
      <template v-slot:item.description="{item}">
        {{item.description | shorten(20)}}
      </template>
      <template v-slot:item.actions="{ item }">
        <span style="display: flex;justify-content: flex-end;align-items: center;">
          <v-icon small @click="editSingleGateway(item)" style="margin:20px">
            mdi-pencil
          </v-icon>
          <v-icon small @click="deleteSingleGateway(item)">
            mdi-delete
          </v-icon>
        </span>
      </template>
    </v-data-table>
    <v-dialog v-model="showDeleteDialog" persistent class="dialog" max-width="420">
      <v-card>
        <v-card-title class="headline dialog_title">Are you sure?</v-card-title>
        <v-card-text class="dialog_columns">Note that this action is not reversible!
        </v-card-text>
        <v-card-actions class="dialog_buttons">
          <v-btn small color="green darken-1" @click="showDeleteDialog=false">No...Please Cancel!
          </v-btn>
          <v-btn small color="error" text @click="deleteGateway">Yes Go Ahead & Delete</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <gateway-form :existingGateway="selectedGateway" v-if="editDialog" @close="editDialog=false"
                  @submit="editGateway"/>
    <gateway-form v-if="addDialog" @submit="addGateway" @close="addDialog=false"/>
  </div>
</template>

<script>
  import Notification from "@/Pages/Components/Notifications/Notification"
  import GatewayForm from "@/Pages/Gateways/Gateway/GatewayForm"

  export default {
    components: {Notification, GatewayForm},
    data() {
      return {
        addDialog: false,
        editDialog: false,
        showDeleteDialog: false,
        options: {},
        sortBy: ['name'],
        sortDesc: false,
        selectedGateways: [],
        selectedGateway: {},
        searchText: '',
        itemsPerPage: 10,
        headers: [
          {
            text: 'Name',
            align: 'start',
            sortable: true,
            value: 'name',
          },
          {
            text: 'Description',
            align: 'start',
            sortable: true,
            value: 'description',
          }, {
            text: 'Gateway',
            align: 'start',
            sortable: true,
            value: 'apiName',
          }, {
            text: 'Key',
            align: 'start',
            sortable: true,
            value: 'apiKey',
          }, {
            text: 'Username',
            align: 'start',
            sortable: true,
            value: 'username',
          },
          {text: '', value: 'actions', sortable: false, align: 'end',},
        ],
      }
    },
    watch: {
      options: {
        handler() {
          this.selectedGateway = []
          this.itemsPerPage = this.items_per_page
          this.$store.commit("setQueryOptions", this.options);
          this.loadGateways()
        }
      }
    },
    methods: {
      searchGateways() {
        aps_globals._.debounce(async () => {
          this.$store.commit("setQuerySearchArray", ['name', this.searchText])
          this.loadGateways();
        })
      },
      select(items) {
        this.selectedGateway = items;
      },
      loadGateways() {
        this.$store.dispatch("loadGateways");
      },
      toggleAllGateways(selected) {
        this.allSelected = selected.value
      },
      async resetQueries() {
        await this.$store.commit("resetQueryState");

      },
      addGateway(gateway) {
        this.addDialog = false;
        this.$store.dispatch("addGateway", gateway)
      },
      editSingleGateway(gateway) {
        this.selectedGateway = aps_globals._.cloneDeep(gateway)
        this.editDialog = true;
      },
      editGateway(gateway) {
        this.editDialog = false
        this.$store.dispatch("updateGateway", gateway)
      },
      deleteSingleGateway(gateway) {
        this.showDeleteDialog = true
        this.selectedGateway = [gateway]
      },
      deleteGateway() {
        this.$store.dispatch("deleteGateway", this.selectedGateway)
        this.showDeleteDialog = false;
        this.selectedGateway = [];
        this.selectedGateways = [];
      },
      goToContacts(gateway) {
        this.$router.push(`/contacts/list?gateway=${gateway.id}`)
      },
      defaultColor(value) {
        return value ? 'success' : 'grey'
      }
    },
    computed: {
      loading() {
        return this.$store.state.loading;
      }
      ,
      rowsNumber() {
        return this.$store.state.gateways.rowsNumber
      },
      items_per_page() {
        return this.$store.state.queries.pagination.queryPagination.itemsPerPage
      },
      gateways() {
        return this.$store.state.gateways.list;
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
      margin-right: 30px;
    }

    .header_select_gateways {
      flex: 1;
    }
  }

  .header {
    display: flex;
    justify-content: space-between;
    margin: 1rem;
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

