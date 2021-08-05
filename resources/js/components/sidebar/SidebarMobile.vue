<template lang="pug">
.mobile-sidebar.d-md-none#mobile-menu.animate__animated.animate__faster
  .d-flex.flex-column
    Icon.icon-close.mx-3.mb-4(name="close" @click.native="toggleMenu()")
    SidebarMenu
</template>

<script lang="ts">
import Vue from 'vue'

import SidebarProfile from './SidebarProfile.vue'
import SidebarCounts from './SidebarCounts.vue'
import SidebarMenu from './SidebarMenu.vue'
import Icon from '../Icon.vue'
import MobileMenu from '../../services/MobileMenu'

export default Vue.extend({
  components: {
    SidebarProfile,
    SidebarCounts,
    SidebarMenu,
    Icon
  },

  methods: {
    toggleMenu () {
      MobileMenu.toggle()
    }
  }
})
</script>

<style lang="sass" scoped>
#mobile-menu
  display: none
  position: absolute
  z-index: 1056
  background: #f8f9fc
  top: 0
  left: 0
  width: 100%
  height: 100vh
  padding-top: 30px
  .icon-close
    width: 16px
    height: 16px
</style>
