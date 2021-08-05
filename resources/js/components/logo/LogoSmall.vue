<template lang="pug">
  .logo
    router-link(:to="{ name: 'Landing' }")
      img(src="/assets/Logo.svg" alt="oceanpace" :class="imgClass")
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  props: ['fullWidth'],
  computed: {
    imgClass () {
      return { 'full-width': this.fullWidth }
    }
  }
})
</script>

<style lang="sass" scoped>
img
  width: 123px
  height: auto
  &.full-width
    width: 100%
</style>
