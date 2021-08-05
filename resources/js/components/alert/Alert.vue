<template lang="pug">
  transition(name="fade")
    .alert-wrapper(:class="`${alert.type}`" role="alert" v-if="alert.message" @click="clear()")
      .row
        .col
          .alert.d-flex.align-items-center.cursor-pointer.mb-0
            .icon-wrapper.d-flex.align-items-center
              Icon.icon.mr-2(:name="iconName")
            span.message {{ alert.message }}
            span
              slot
</template>

<script lang="ts">
import Vue from 'vue'
import AlertState from '../../State/AlertState'

import Icon from '../Icon.vue'

export default Vue.extend({
  components: {
    Icon
  },

  computed: {
    alert () {
      return AlertState.collectAlert()
    },
    iconName () {
      return this.alert.type === 'error' ? 'close-alt' : 'accept'
    }
  },

  methods: {
    clear () {
      AlertState.pullAlert()
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

.alert-wrapper
  position: fixed
  bottom: 30px
  left: 30px
  right: 30px
  z-index: 1060
  .alert
    border: none
    color: #2D3339
    background: #EFEFEF
    width: fit-content
    max-width: 425px
    padding: 17px 20px
    .icon
      width: 17px
      height: 17px
    .message
      width: fit-content
  &.error
    .icon
      fill: $red
  &.success
    .icon
      fill: $green

@media (max-width: 576px)
  .alert
    font-size: 0.85rem
</style>
