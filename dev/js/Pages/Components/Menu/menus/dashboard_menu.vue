<template>
  <div>
    <v-list-item
        style="top:-8px"
        key="dashboard"
        link
        to="/"
    >
      <v-list-item-action>
        <v-icon>mdi-view-dashboard</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>
          SMS Dashboard
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </div>
</template>

<script>
  export default {
    name:"dashboard_menu",
    data() {
      return {}
    },
    methods: {},
    computed: {}
  }

</script>
