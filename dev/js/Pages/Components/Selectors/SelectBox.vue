<template>
  <div :id="id" class="apps_bay_sms_manager_dashboard_selector">
    <v-select
        :disabled="disabled"
        clearable
        @click:clear="selected"
        @input="selected"
        v-model="selectedID"
        :attach="idNotation"
        class="header_select"
        :items="items"
        :label=label
        :chips="chips"
        :multiple="multiple"
        :small-chips="smallChips"
        :item-text="text"
        :item-value="value"
        :hint="hint"
        :persistent-hint="persistentHint"
    ></v-select>
  </div>
</template>

<script>
  export default {
    mounted() {
      if (this.propSelectedID) {
        this.selectedID = this.propSelectedID
      }
    },
    props: {
      "persistentHint": {
        default: false
      },
      hint: {
        default: ""
      },
      clearable: {
        default: false
      },
      disabled: {
        default: false
      },
      "smallChips": {
        default: false
      },
      multiple: {
        default: false
      },
      chips: {
        default: false
      },
      propSelectedID: {
        default: null
      },
      'items': {
        default: () => []
      },
      'label': {
        default: "Select"
      },
      'text': {},
      'value': {
        default: null
      }
    },
    data() {
      return {
        selectedID: null
      }
    },
    methods: {
      selected(value) {
        this.$emit("selected", value)
      },
    },
    computed: {
      id() {
        return aps_globals._.isRandomText(50)
      },
      idNotation() {
        return `#${this.id}`
      }
    }
  }

</script>
<style lang="scss" scoped>
  .apps_bay_sms_manager_dashboard_selector {
    position: relative;
  }
</style>
