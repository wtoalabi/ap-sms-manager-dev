<template>
  <div>
    <v-list-item
        key="groups"
        link
        to="/groups/list"
    >
      <v-list-item-action>
        <v-icon>mdi-account-multiple</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>
          Groups
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
