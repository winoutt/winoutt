<template lang="pug">
.panel-public
  .container.h-100.px-3#content
    .row
      .col-md-126.offset-md-9
        .header.row.no-gutters.sticky-top

          //- Mobile
          .col-55.d-block.d-md-none.d-flex.align-items-center.mt-2
            LogoLarge(:isMobile="true")
          .col-89.d-block.d-md-none.d-flex.justify-content-end.mt-2
            AuthButtons.auth-buttons

          //- Global
          .col-md-80.col-xl-96
            nav.navbar.navbar-expand-lg.navbar-light.w-100.px-0.py-2.py-md-3
              LogoLarge.mr-3.d-none.d-md-block
              SearchAll.mt-3.mt-lg-0
          .col-md-64.col-xl-48.align-items-center.justify-content-center.pl-3.d-none.d-md-flex
            AuthButtons.auth-buttons
        .row.position-relative
          .col-md-80.col-xl-96
            slot
          .col-md-64.col-xl-48
            .sticky-top
              Aside
    Slider
</template>

<script lang="ts">
import Vue from 'vue'

import LogoLarge from '../logo/LogoLarge.vue'
import AuthButtons from '../AuthButtons.vue'
import Aside from '../aside/Aside.vue'
import SearchAll from '../SearchAll.vue'
import Slider from '../Slider.vue'

export default Vue.extend({
  components: {
    LogoLarge,
    AuthButtons,
    Aside,
    SearchAll,
    Slider
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

.panel-public
  background: $grey-light
  min-height: 100%
  .header
    background: $grey-light
    z-index: 1021
    .navbar
      padding-right: 10px !important

.sticky-top
  top: -350px // To fix the content stick on top, not scrolling to bottom

@media (max-width: 767px)
  .panel-public .header .navbar
    padding-right: 0 !important

@media (min-width: 768px) and (max-width: 992px)
  .auth-buttons
    margin-top: 60px

@media (min-width: 1360px)
  .container
     max-width: 1140px
</style>
