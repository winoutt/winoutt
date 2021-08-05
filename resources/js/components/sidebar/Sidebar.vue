<template lang="pug">
  .row.sidebar.h-100.border-right
    .col.mb-3
      .sticky-top
        LogoSmall.logo.mb-3.pt-3.pt.px-3.mb-5
        SidebarProfile
        SidebarCounts
        SidebarMenu
</template>

<script lang="ts">
import Vue from 'vue'

import LogoSmall from '../logo/LogoSmall.vue'
import SidebarProfile from './SidebarProfile.vue'
import SidebarCounts from './SidebarCounts.vue'
import SidebarMenu from './SidebarMenu.vue'

export default Vue.extend({
  components: {
    LogoSmall,
    SidebarProfile,
    SidebarCounts,
    SidebarMenu
  }
})
</script>
