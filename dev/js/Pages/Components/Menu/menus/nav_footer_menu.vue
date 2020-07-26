<template>
  <div>
    <v-divider></v-divider>
    <div class="icons-row" :class="ifMenuVariant">
      <div class="version">
        <version-display/>
      </div>
      <div class="theme">
      <theme-changer />
      </div>
    </div>
  </div>
</template>

<script>
  import ThemeChanger from "../partials/ThemeChanger"
  import VersionDisplay from "../partials/VersionDisplay"
  export default {

    components:{ThemeChanger,VersionDisplay},
    data() {
      return {}
    },
    methods: {},
    computed: {
      ifMenuVariant(){
        if(this.$store.state.miniDrawer){
          return 'column'
        }
      }
    }
  }

</script>
<style lang="scss" scoped>
  .column{
    flex-direction: column !important;
  }
  .icons-row{
    padding: .5rem 1rem;
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: space-between;
    .version{
      flex: 3;
    }
    .theme{
      display: flex;
      flex: 4;
      justify-content: flex-end;
    }
  }
</style>
