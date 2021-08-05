<template lang="pug">
  button.btn.btn-primary.btn-block.shadow-none.d-flex.align-items-center.justify-content-center
    Icon.icon.mr-2(v-if="icon" :name="icon")
    | {{ text }}
</template>

<script lang="ts">
import Vue from 'vue'
import Icon from '../Icon.vue'

export default Vue.extend({
  props: ['text', 'icon'],
  components: {
    Icon
  }
})
</script>

<style lang="sass" scoped>
button
  padding-top: 9.5px
  padding-bottom: 9.5px
  font-size: 0.875rem
  .icon
    width: 16px
    height: 16px
    fill: white
</style>
