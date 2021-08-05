<template lang="pug">
  .dropdown
    .dropdown-icon.d-flex.cursor-pointer(data-toggle='dropdown' aria-haspopup='true' aria-expanded='false')
      Icon.icon-more-horizontal(name="more-horizontal" v-if="horizontal")
      Icon.icon-more(name="more" v-else)
    .dropdown-menu.dropdown-menu-right.shadow
      slot
</template>

<script lang="ts">
import Vue from 'vue'
import Icon from './Icon.vue'

export default Vue.extend({
  props: ['horizontal'],
  components: {
    Icon
  }
})
</script>

<style lang="sass" scoped>
.dropdown-menu
  top: 4px !important

.dropdown-icon
  height: fit-content
  .icon-more-horizontal
    height: 5px
    width: 13px
  .icon-more
    width: 5px
    height: 13px
</style>
