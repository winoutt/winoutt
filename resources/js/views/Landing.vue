<template lang="pug">
  .landing.bg-light.position-relative
  .header-wrapper.position-fixed.w-100.bg-white
  .container
  header.d-flex.mt-3.pb-3.align-items-center.w-100.justify-content-between
  .logo
  LogoLarge(:isMobile="true")
  .d-flex.justify-content-end.pr-0.pr-md-1
  AuthButtons
  .container.landing-wrapper.d-block.d-md-flex.flex-column.justify-content-between.position-relative
  .d-block.d-md-flex.flex-column.justify-content-center.h-100
  .row.d-block.d-md-flex.landing-main.mt-3.mt-sm-0
  .col-md-81
  h2
  | Join a leading community for
  br
  | Entrepreneurs, Intrapreneurs, and
  br
  | Investors
  p Oceanpace is a worldwide community of aspiring and established entrepreneurs who connect, collaborate, and lead the way in innovation and life transformation. Be comfortable sharing your vision, ideas, and experiences. We are a place to learn, grow, and succeed in any desired industry.
  h5 Connect. Collaborate. Create Value.
  h5.mb-0 Leave your mark on the world.
  .col-md-63
  .image.d-flex.align-items-center.h-100
  img.img-fluid.my-4.my-md-0(src="/assets/startup.svg")
  .row.landing-footer
  .col-md-90
  Footer.text-left
</template>

<script lang="ts">
  import Vue from 'vue'
  import AuthToken from '../services/AuthToken'

  import LogoLarge from '../components/logo/LogoLarge.vue'
  import Footer from '../components/Footer.vue'
  import InputPassword from '../components/input/InputPassword.vue'
  import AuthButtons from '../components/AuthButtons.vue'

  export default Vue.extend({
    components: {
      LogoLarge,
      Footer,
      InputPassword,
      AuthButtons
    },

    beforeRouteEnter(to, from, next) {
      if (AuthToken.has()) next({ name: 'Home' })
      else next()
    }
  })
</script>

<style lang="sass" scoped>
  header background: #fefefe .header-wrapper z-index: 1 top: 0 .landing-wrapper top: 78px height: calc(100% - 78px) h2 font-size: 2.3125rem margin-bottom: 23px p font-size: 1.125rem line-height: 1.5 margin-bottom: 23px h5 font-size: 1.375rem line-height: 1.5 @media (min-width: 1360px) .container max-width: 1140px @media (min-width: 768px) .landing height: 100%

</style>

<style lang="sass">
  @media (min-width: 425px) .landing .logo img width: 153px height: auto

</style>
