<template lang="pug">
  .error-page.container.h-100
    .row.error-page-wrapper.align-items-center.h-100
      .col-md-56.offset-md-44.col-lg-42.offset-lg-51.d-flex
        .wrapper.d-block.mx-auto
          LogoLarge.logo
          h1.code.mb-0 {{ code }}
          .line
          p.description {{ description }}
          ButtonLarge.back-button.px-4(text="Go back to Home" @click.native="returnToHome()")
</template>

<script lang="ts">
import Vue from 'vue'
import LogoLarge from './logo/LogoLarge.vue'
import ButtonLarge from './button/ButtonLarge.vue'

export default Vue.extend({
  props: ['code', 'description'],
  components: {
    LogoLarge,
    ButtonLarge
  },

  methods: {
    returnToHome () {
      this.$router.push({ name: 'Home' })
    }
  }
})
</script>

<style lang="sass" scoped>
.error-page-wrapper
  .logo
    margin-bottom: 37px
  .code
    font-size: 4.3125rem
  .line
    width: 111px
    height: 4px
    border-radius: 3px
    background-color: #212529
    margin-bottom: 18px
  .description
    margin-bottom: 39px
    font-size: 1rem
  .back-button
    width: fit-content
</style>
