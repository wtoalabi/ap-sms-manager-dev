<template>
  <div>
    <v-list-item
        key="send-sms"
        to="/send-sms"
        link
    >
      <v-list-item-action>
        <v-icon>mdi-send</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>
          Send SMS
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </div>
</template>

<script>
  export default {
    data() {
      return {}
    },
    methods: {},
    computed: {}
  }

</script>
