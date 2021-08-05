<template lang="pug">
  .article.container.h-100
    PublicWrapper
      .main
        .logo.text-center
          LogoLarge
        h2.text-center {{ title }}
        .row
          div(:class="customSized ? 'col-sm-132 offset-sm-6 col-md-122 offset-md-11 col-lg-72 offset-lg-36' : 'col-md-108 offset-md-18'")
            .content
              slot
</template>

<script lang="ts">
import Vue from 'vue'
import LogoLarge from './logo/LogoLarge.vue'
import PublicWrapper from './PublicWrapper.vue'

export default Vue.extend({
  props: {
    title: { type: String },
    customSized: { default: false }
  },
  components: {
    LogoLarge,
    PublicWrapper
  }
})
</script>

<style lang="sass" scoped>
.logo
  margin-bottom: 60px
h2
  margin-bottom: 35px
  font-size: 1.8125rem
  font-weight: 700
.content
  margin-bottom: 75px
</style>
