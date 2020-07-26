<template>
  <div>
    <div>
     You can use the box below to input the numbers one by one, per line.<br />
      <p><strong>For example,</strong> if the number is 08163684917 and the country code of the recipient is +211, then you need to format it like so: +2118163684917. Note that the first 0 is collapsed.</p>
    </div>
    <v-textarea
        @input="inputContacts"
        v-model="numbers"
        filled
        auto-grow
        persistent-hint
        name="input-7-1"
        label="Input Contacts"
        placeholder="Put each contact number here, one per line."
    ></v-textarea>
    <select-box
        :prop-selected-i-d="selectedGroup"
        @selected="groupSelected"
        :items="groups" text="name" value="id"
        label="Choose Group"/>
    <div v-if="loading">
      <v-progress-linear
          indeterminate
          color="success"
      ></v-progress-linear>
    </div>
    <div v-else>
      <div v-if="errorMessage">
        <div class="error--text mt-3 mb-3">{{errorMessage}}</div>
      </div>
      <v-btn @click="save" :disabled="disableButton">Save</v-btn>
      <saved-action-buttons/>
    </div>

  </div>
</template>

<script>
  import SelectBox from "@/Pages/Components/Selectors/SelectBox";
  import SavedActionButtons from "@/Pages/AddContacts/partials/SavedActionButtons";

  export default {
    mounted() {},
    components: {SelectBox, SavedActionButtons},
    data() {
      return {
        numbers: [],
        errorMessage: null,
        selectedGroup: ""
      }
    },
    methods: {
      save() {
        if (!this.selectedGroup) {
          this.errorMessage = "You need to select a group"
          return;
        }
        let numbers = this.process();
        if (numbers) {
          let data = {
            group_id: this.selectedGroup,
            numbers: numbers,
            source: "InputNumbers"
          }
          this.$store.dispatch("saveContacts", data)
          this.reset()
        }
      },
      process() {
        let arr = this.numbers.split("\n");
        if (arr.every(each => aps_globals._.isPhoneNumber(each))) {
          return arr;
        } else {
          this.errorMessage = "Make sure all the input numbers are in the right format, like so: +2118163684917"
        }
      },
      inputContacts() {
        this.errorMessage = null;
      },
      reset() {
        this.numbers = [];
        this.errorMessage = null;
      },
      groupSelected(group) {
        this.selectedGroup = group
      },
    },
    computed: {
      groups() {
        return this.$store.state.groups.metaList.filter(g => g.id >= 1)
      },
      contactsSaved() {
        return this.$store.state.contacts.contactsSaved;
      },
      loading() {
        return this.$store.state.loading;
      },
      disableButton(){
        return this.numbers.length === 0  || aps_globals._.isNotEmpty(this.errorMessage);
      }
    }
  }

</script>
