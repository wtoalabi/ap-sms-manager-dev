<template>
  <div>
    <v-row>
      <v-col cols="12" sm="6" md="3" class="p-0">
        <div class="display">
          <button @click="addContacts">
            <v-alert
                text
                prominent
                :icon="false"
                type="info"
            >
              <v-icon color="info" large>mdi-account-multiple-plus-outline</v-icon>
              <div class="display__title">Add Contacts</div>
              <div class="display__info">One by One or in Bulk</div>
            </v-alert>
          </button>
        </div>
      </v-col>
      <v-spacer />
      <v-col cols="12" sm="6" md="3" class="p-0">
        <div class="display">
          <button @click="sendSMS" :disabled="noSelectedContacts" :style="cursorType">
            <v-alert
                prominent
                :icon="false"
                type="info"
                :color="noSelectedContacts ? 'grey': null"s
            >
              <v-icon color="white" large>mdi-send</v-icon>
              <div class="display__title">Send SMS!</div>
              <div class="display__info">to selected {{contactsText}}</div>
            </v-alert>
          </button>
        </div>
      </v-col>
    </v-row>
  </div>
</template>

<script>
  export default {
    data() {
      return {}
    },
    methods: {
      uploadContacts() {
        this.$router.push("/contacts-sync?upload=true")
      },
      sendSMS() {
        this.$router.push("/send-sms")
      },
      addContacts(){
        this.$router.push("/add-contacts?add=true")
      },
      syncContacts(){
        this.$router.push("/add-contacts?sync=true")
      }
    },
    computed: {
      selectedContacts(){
        return this.$store.state.contacts.selectedContacts;
      },
      noSelectedContacts(){
        return aps_globals._.isEmpty(this.selectedContacts)
      },
      cursorType(){
        if (this.noSelectedContacts){
          return {'cursor':'not-allowed'}
        }
          return {'cursor':'pointer'}
      },
      contactsText(){
        if(this.selectedContacts.length>0){
          return this.selectedContacts.length > 1 ? `${this.selectedContacts.length} contacts` : 'contact'
        }else{
          return 'contacts'
        }
      }
    }
  }

</script>

<style scoped lang="scss">
  .display {
    padding: 0 1rem;
    text-align: center;

    button {
      width: 175px;
      @media screen and (min-width:1920px){
        width: 100%;
      }
    }

    .display__title {
      font-size: 1rem;
    }

    .display__info {
      font-size: .7rem;
    }
  }
</style>
