<template lang="pug">
  li
    router-link.menu-item.d-flex.align-items-center(:to="{ name: router ? router : name }" @click.native="hideMobileMenu()" :target="target")
      Icon.icon-menu-item.mr-3(:name="isActivePage ? `${icon}-active` : icon")
      h6.mb-0 {{ name }}
      Indicator.indicator-icon(:canShow="count")
</template>

<script lang="ts">
import Vue from 'vue'

import Icon from '../Icon.vue'
import Indicator from '../Indicator.vue'
import MobileMenu from '../../services/MobileMenu'

export default Vue.extend({
  props: ['name', 'icon', 'router', 'count', 'target'],
  components: {
    Icon,
    Indicator
  },

  computed: {
    isActivePage () {
      const routeName = this.router ? this.router : this.name
      const activeRouteName = this.$route.name
      return routeName === activeRouteName
    }
  },

  methods: {
    hideMobileMenu () {
      MobileMenu.hide()
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

li
  .menu-item
    text-decoration: none
    padding: 11px 15px
    .icon-menu-item
      width: 18px
      height: 18px
      transition: 0.4s
      margin-right: 22px !important
    h6
      font-size: 0.875rem
      color: $body-color
      transition: 0.4s
    .indicator-icon
      margin-left: 20px
    &:hover
      h6
        color: $primary
      .icon-menu-item
        fill: $primary
    &.router-link-active
      h6
        font-weight: 700
        color: $primary
      .icon-menu-item
        fill: $primary
</style>
