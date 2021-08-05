<template lang="pug">
  .account-delete.h-100.bg-light
    .container.h-100
      .main.d-flex.flex-column.justify-content-center.h-100
        .row
          .col-md-90.offset-md-27.text-center
            Icon.icon-accept-active.mb-5(name="accept-active")
            h2 Account deleted successfully
            .lead Your account will be logged out automatically
</template>

<script lang="ts">
import Vue from 'vue'
import Icon from '../components/Icon.vue'

export default Vue.extend({
  components: {
    Icon
  },

  beforeRouteEnter (to, from, next) {
    if (from.name !== 'Settings') next({ name: 'Landing' })
    else next()
  },

  methods: {
    routeToLanding () {
      setTimeout(() => {
        this.$router.push({ name: 'Landing' })
      }, 4000)
    }
  },

  mounted () {
    this.routeToLanding()
  }
})
</script>

<style lang="sass" scoped>
@import '../../sass/variables'

.icon-accept-active
  width: 140px
  height: 140px
  fill: $green
.lead
  font-size: 1.24rem
</style>
