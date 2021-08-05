<template lang="pug">
  .custom-control.custom-switch.d-flex.align-items-center.pl-0.cursor-pointer
    Icon.icon-toggle.mr-3(:name="value ? 'toggle-active' : 'toggle'")
    p.mb-0(:class="value ? 'font-weight-bold' : ''") {{ text }}
</template>

<script lang="ts">
import Vue from 'vue'
import Icon from './Icon.vue'

export default Vue.extend({
  props: ['value', 'text'],
  components: {
    Icon
  }
})
</script>

<style lang="sass" scoped>
.icon-toggle
  width: 42px
  height: 23px
</style>
