<template>
  <div v-if="showNotification" class="mt-4">
    <transition
        name="custom-classes-transition"
        enter-active-class="animate__animated animate__fadeInUp">
      <v-alert
          :icon="notification.icon"
          prominent
          text
          :type="notification.type">
        {{notification.text}}
      </v-alert>
    </transition>
  </div>
</template>

<script>
  import {scrollToTop} from "@/utils/helpers/documents";

  export default {
    data() {
      return {}
    },
    watch: {
      notification: {
        handler() {
          scrollToTop()
        }
      }
    },
    methods: {},
    computed: {
      notification() {
        return this.$store.state.notifications
      },
      showNotification() {
        return aps_globals._.isNotEmpty(this.notification);
      }
    }
  }

</script>
