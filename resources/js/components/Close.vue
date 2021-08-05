<template lang="pug">
  button.close.d-flex.p-2.rounded-circle(type='button' data-dismiss='modal' aria-label='Close')
    Icon.icon-close(name="close" aria-hidden='true')
</template>

<script lang="ts">
import Vue from 'vue'
import Icon from './Icon.vue'

export default Vue.extend({
  components: {
    Icon
  }
})
</script>

<style lang="sass" scoped>
@import '../../sass/variables'

.close
  outline: none
  transition: 0.4s
  .icon-close
    width: 13px
    height: 13px
  &:hover
    background: $grey
</style>
