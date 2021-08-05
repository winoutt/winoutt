<template lang="pug">
  .aside-footer(:class="topMargin")
  ul.d-flex.p-0.mb-2.justify-content-center
  li(v-if="!hasAuth")
  router-link(:to="{ name: 'AboutUs' }" target="_blank") About
  li
  router-link(:to="{ name: 'Help' }" target="_blank") Help
  li
  router-link(:to="{ name: 'PrivacyPolicy' }" target="_blank") Privacy Policy
  li
  router-link(:to="{ name: 'TermsOfUse' }" target="_blank") Terms Of Use
  p.mb-2.text-center Copyright © 2020 Oceanpace
</template>

<script lang="ts">
  import Vue from 'vue'
  import { every, isEmpty } from 'lodash'

  import UserState from '../../State/UserState'
  import HashtagState from '../../State/HashtagState'
  import AuthToken from '../../services/AuthToken'

  export default Vue.extend({
    computed: {
      topMargin() {
        const asidables = [ HashtagState.collectHashtags(), UserState.collectUsers() ]
        const canMargin = every(asidables, data => isEmpty(data))
        return { 'top-margin': canMargin }
      },
      hasAuth() {
        return AuthToken.has()
      }
    }
  })
</script>

<style lang="sass" scoped>
  .aside-footer ul list-style: none li font-size: 0.813rem margin-right: 23px &:last-child margin-right: 0 p font-size: 0.75rem &.top-margin margin-top: 45px !important

</style>
