<template lang="pug">
  .footer
  ul.d-flex.p-0.m-0.mb-2
  li.mr-4
  router-link(:to="{ name: 'AboutUs' }" target="_blank") About
  li.mr-4
  router-link(:to="{ name: 'Help' }" target="_blank") Help
  li.mr-4
  router-link(:to="{ name: 'PrivacyPolicy' }" target="_blank") Privacy Policy
  li
  router-link(:to="{ name: 'TermsOfUse' }" target="_blank") Terms Of Use
  p Copyright © 2020 Oceanpace
</template>

<script lang="ts">
  import Vue from 'vue'
  export default Vue.extend({

  })
</script>

<style lang="sass" scoped>
  ul list-style: none li font-size: 0.875rem p margin-bottom: 30px font-size: 0.813rem @media (max-width: 576px) ul li font-size: 0.75rem

</style>
