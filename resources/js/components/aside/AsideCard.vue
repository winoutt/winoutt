<template lang="pug">
  .card
    slot(name="card-content")
    .card-body(v-if="enableBody")
      slot(name="card-body")
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: {
    enableBody: { default: true }
  }
})
</script>

<style lang="sass" scoped>
.card
  border-radius: 3px
  .card-body
    padding: 20px 30px
    padding-bottom: 13px
</style>
