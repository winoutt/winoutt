<template lang="pug">
  .logo
    router-link(:to="{ name: 'Landing' }")
      img(src="/assets/Logo.svg" alt="oceanpace" :class="mobileClass")
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  props: ['isMobile'],

  computed: {
    mobileClass () {
      return { mobile: this.isMobile }
    }
  }
})
</script>

<style lang="sass" scoped>
img
  width: 153px
  height: auto
  &.mobile
    width: 120px
</style>
