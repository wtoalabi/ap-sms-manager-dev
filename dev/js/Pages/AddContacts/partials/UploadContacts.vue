<template>
  <div>
    <div>
      Instead of uploading your numbers one by one, you can mass upload
      up to 1000 mobile numbers at the same time.
      <br/> To do this, prepare a notepad or a text file (e.g Notepad) and put the number on each line.
      <br/> However, each number should be formatted in a way providers required, that is, append the '+'
      and the recipients country code before the number itself.
      <br/>For instance, if the country code is 111 and the recipient number is 0617277485...
      <br/> The valid number to upload would be +111617277485
      <br/><span style="font-weight: bolder">Note that the first 0 in the recipient's number is collapsed!</span>
      <br />
      <br/><a @click="downloadSample">Click here</a> to download a sample text file on how this
      should look like.
    </div>
    <v-file-input
        @click:clear="errorMessage=''"
        @click="errorMessage = ''"
        v-model="uploadedFile"
        @change="processNumbers"
        persistent-hint
        class="mt-4"
        outlined
        color="deep-purple accent-4"
        hint="Accepted file formats/extensions are .txt, .csv"
        accept=".txt,.csv"
        label="Bulk Mobile Numbers Upload"></v-file-input>
    <div class="error--text ml-6 mt-3">{{errorMessage}}</div>
    <div v-if="uploadedMessage">
      <div>{{uploadedMessage}}</div>
      <div class="mt-3">
        <select-box
            :prop-selected-i-d="selectedGroup"
            @selected="groupSelected"
            :items="groups" text="name" value="id"
            label="Choose Group"/>
      </div>
      <div class="buttons">
        <v-btn small color="green darken-1" text @click="cancelUpload">Cancel
        </v-btn>
        <v-btn small color="error" @click="saveNumbers">Save</v-btn>
      </div>
    </div>
    <div v-if="loading">
      <v-progress-linear
          indeterminate
          color="success"
      ></v-progress-linear>
    </div>
    <div v-else>
      <saved-action-buttons/>
    </div>
  </div>
</template>

<script>
  import SelectBox from "@/Pages/Components/Selectors/SelectBox"
  import SavedActionButtons from "@/Pages/AddContacts/partials/SavedActionButtons";

  export default {
    components: {SelectBox,SavedActionButtons},
    mounted() {
      this.$store.commit("toggleSavedContactsFlag")},
    data() {
      return {
        selectedGroup: null,
        uploadedMessage: null,
        errorMessage: "",
        uploadedFile: [],
        uploadedNumbers: [],
        maxPer: 1000
      }
    },
    methods: {
      groupSelected(group) {
        this.selectedGroup = group
      },
      cancelUpload() {
        this.reset()
      },
      saveNumbers() {
        if (!this.selectedGroup) {
          this.errorMessage = "You need to select a group"
          return;
        }
        let data = {
          group_id: this.selectedGroup,
          numbers: this.uploadedNumbers,
          source: "UploadedFile"
        }
        this.$store.dispatch("saveContacts", data)
        this.reset()
      },
      reset() {
        this.uploadedNumbers = [];
        this.uploadedMessage = null
        this.errorMessage = null;
        this.uploadedFile = null;
      },
      processNumbers(file) {
        this.$store.commit("toggleSavedContactsFlag")
        this.uploadedNumbers = [];
        if (file) {
          Papa.parse(file, {
            complete: (results, file) => {
              if (results) {
                let data = results['data'];
                if (data) {
                  for (let i = 0; i < data.length; i++) {
                    let number = data[i][0];
                    if (aps_globals._.isPhoneNumber(number)) {
                      this.uploadedNumbers.push(number)
                    }
                  }
                  if (this.uploadedNumbers.length === 0) {
                    this.errorMessage = "We cannot find any valid number in the uploaded document. Please check and try again. Note, each number should be on one line and each should be formatted like so: +22284786987094"
                    return ;
                  }

                  if (this.uploadedNumbers.length > this.maxPer) {
                    this.errorMessage = `Uploaded file contains ${this.uploadedNumbers.length} phone numbers! You cannot upload more than ${this.maxPer} at a time though. Please re-adjust your document and try again.`
                  } else {
                    this.$emit("uploaded", this.uploadedNumbers)
                    this.uploadedMessage = `We found ${this.uploadedNumbers.length} numbers. You can choose the group next...`
                  }
                }
              }
            }
          })
        }
      },
      downloadSample(e) {
        e.preventDefault();
        let a = document.createElement("a");
        a.href = `${aps_globals.pluginUrl}Assets/samples/sample_mobile_numbers.txt`;
        a.setAttribute("download", 'sample_mobile_numbers');
        a.click();
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
    }
  }

</script>

<style scoped lang="scss">
  .title {
    font-size: 1.2rem;
    margin: 0 !important;
  }

  .buttons {
    display: flex;
    justify-content: space-between;
  }
</style>
