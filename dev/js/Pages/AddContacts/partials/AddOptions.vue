<template>
  <div>
    <h1>Premium</h1>
    <v-row>
      <v-col cols="12" md="4">
        <div class="display">
          <button @click="uploadContacts">
            <v-alert
                prominent
                :icon="false"
                type="info"
                :text="isActive('uploadContacts').isText"
            >
              <v-icon :color="isActive('uploadContacts').iconColor" large>mdi-progress-upload
              </v-icon>
              <div class="display__title">Upload Contacts</div>
              <div class="display__info">from your computer</div>
            </v-alert>
          </button>
        </div>
      </v-col>
      <v-col cols="12" md="4">
        <div class="display">
          <button @click="syncContacts">
            <v-alert
                prominent
                :icon="false"
                type="info"
                :text="isActive('syncContacts').isText">
              <v-icon :color="isActive('syncContacts').iconColor" large>mdi-sync-circle</v-icon>
              <div class="display__title">Sync Wordpress</div>
              <div class="display__info">from Woocommerce, etc</div>
            </v-alert>
          </button>
        </div>
      </v-col>
      <v-col cols="12" md="4">
        <div class="display">
          <button @click="inputContacts">
            <v-alert
                prominent
                :icon="false"
                type="info"
                :text="isActive('inputContacts').isText"
            >
              <v-icon :color="isActive('inputContacts').iconColor" large>
                mdi-account-multiple-plus-outline
              </v-icon>
              <div class="display__title">Input Manually</div>
              <div class="display__info">one by one</div>
            </v-alert>
          </button>
        </div>
      </v-col>
    </v-row>
  </div>
</template>

<script>
  export default {
    mounted() {
      let tab = Object.keys(this.$route.query)[0];
      if(tab){
        this.activeTab = tab;
      }else{
        this.activeTab =   "uploadContacts"
      }
    },
    data() {
      return {
        activeTab: ""
      }
    },
    methods: {
      uploadContacts() {
        this.processTab("uploadContacts")
      },
      sendSMS() {
        this.$router.push("/send-sms")

      },
      inputContacts() {
        this.processTab("inputContacts")
      },
      syncContacts() {
        this.processTab("syncContacts")
      },

      processTab(tab) {
        if (this.activeTab !== tab) {
          this.activeTab = tab
          this.$emit("tabSelected", tab)
          this.$router.push(`/add-contacts?${tab}=true`)
        }
      },
      isActive(id) {
        if (this.activeTab === id) {
          return {
            isText: false,
            iconColor: "white"
          }
        } else {
          return {
            isText: true,
            iconColor: "info"
          }
        }
      },
    },
    computed: {}
  }

</script>

<style scoped lang="scss">
  .display {
    text-align: center;
    padding: 0 1rem;

    button {
      width: 175px;
      @media screen and (min-width: 1920px) {
        width: 100%;
      }
    }

    .display__title {
    }

    font-size: 1rem;

    .display__info {
      font-size: .7rem;
    }
  }
</style>
