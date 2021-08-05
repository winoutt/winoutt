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
  border-width: 1px
  padding: 5px 24px
</style>
