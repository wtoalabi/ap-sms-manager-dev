<template>
  <div>
    <v-list-item
        link
        :ripple="false"
        class="item"
        key="theme"
        @click="changeTheme"
    >
      <v-list-item-action style="margin: 0;padding: 0">
        <v-icon
            v-if="$vuetify.theme.dark">
          mdi-brightness-4
        </v-icon>
        <v-icon v-else>
          mdi-brightness-7
        </v-icon>
      </v-list-item-action>
    </v-list-item>
  </div>
</template>

<script>
  export default {
    data() {
      return {}
    },
    methods: {
      changeTheme() {
        this.$vuetify.theme.dark = !this.$vuetify.theme.dark
      }
    },
    computed: {
      themeText() {
        return this.$vuetify.theme.dark ? "Light Theme" : "Dark Theme"
      }
    }
  }

</script>
<style scoped lang="scss">
  .item {
    margin: 0;
    padding: 0;
     &:before, &:focus{
     background: transparent !important;
    }
  }
</style>
