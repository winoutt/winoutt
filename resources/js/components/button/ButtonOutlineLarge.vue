<template lang="pug">
  button.btn.btn-outline-primary.btn-block.shadow-none.d-flex.align-items-center.justify-content-center
    Icon.icon.mr-2(v-if="icon" :name="icon")
    span.d-none.d-lg-block {{ text }}
    span.d-block.d-lg-none {{ mobileText }}
</template>

<script lang="ts">
import Vue from 'vue'
import Icon from '../Icon.vue'

export default Vue.extend({
  props: ['text', 'mobileText', 'icon'],
  components: {
    Icon
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/buttons'

button
  padding-top: 8.5px
  padding-bottom: 8.5px
  font-size: 0.875rem
  border-width: 1px
  .icon
    width: 16px
    height: 16px
    fill: $primary
  &:hover
    .icon
      fill: white
</style>
