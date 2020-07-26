<template>
  <div>
    <v-alert
        text
        prominent
        type="error"
    >
      <v-row align="center">
        <v-col class="grow" style="text-align: center">You are yet to register a single contact. <br />You need at least one contact before you can start sending messages.</v-col>
        <v-col class="shrink">
          <v-btn color="error" @click="addContacts">Click to Add Some!</v-btn>
        </v-col>
      </v-row>
    </v-alert>
  </div>
</template>

<script>
  export default {
    data() {
      return {}
    },
    methods: {
      addContacts(){
        this.$router.push("/add-contacts")
      }
    },
    computed: {}
  }

</script>
