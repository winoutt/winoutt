<template lang="pug">
  div(data-description='dummyPanel for Chrome auto-fill issue')
    input(type='text' data-description='dummyUsername')
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({})
</script>

<style lang="sass" scoped>
div
  overflow: hidden
  height: 0px
  background: transparent
  input
    height:0
    background: transparent
    color: transparent
    border: none
</style>
