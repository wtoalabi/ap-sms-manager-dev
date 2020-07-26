<template>
  <v-form
      ref="form"
      v-model="valid"
      lazy-validation
  >
    <colors @changeColors="changeColors"/>

    <v-btn
        color="error"
        class="mr-4"
        @click="reset"
    >
      Reset To Default
    </v-btn>

    <v-btn
        color="success"
        @click="save"
        :loading="loading"
    >
      Save Settings
    </v-btn>
  </v-form>
</template>

<script>
  import Colors from './Colors'
  export default {
    components:{Colors},
    mounted() {
    },
    data() {
      return {
        form: {},
        valid: true,
      }
    },
    methods: {
      save() {
        this.$store.dispatch("saveSettings", {'settings':this.form})
      },
      reset() {
        this.$refs.form.reset()
        this.$store.commit("resetSettings")
        this.$store.dispatch("resetSettings")
      },
      changeColors(incomingColors) {
        this.$store.commit("setSettings", incomingColors)
        this.form.themeColors = incomingColors.themeColors
      }
    },
    computed: {
      loading(){
        return this.$store.state.loading;
      },
      settings() {
        return this.$store.state.settings
      },
      colorIsLoaded() {
        return this.$store.state.settings.themeColors.primaryColor
      }
    }
  }

</script>
