<template lang="pug">
  button.btn.btn-outline-primary.shadow-none
    | {{ text }}
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: ['text']
})
</script>

<style lang="sass" scoped>
button
  padding: 6px 20px
  font-size: 0.875rem
  border-width: 1px
  height: fit-content
</style>
