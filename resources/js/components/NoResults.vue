<template lang="pug">
.no-results
  p.lead {{ text }}
  p.subtext {{ subtext }}
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: {
    text: {
      default: 'No results found.'
    },
    subtext: {}
  }
})
</script>

<style lang="sass" scoped>
.no-results
  .lead
    margin-bottom: 6px
  .subtext
    color: #9DA4B2
</style>
