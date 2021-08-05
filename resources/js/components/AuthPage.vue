<template lang="pug">
  .auth-page.h-100.bg-light
    .container.h-100
      PublicWrapper(:fixedHeight="true")
        .main.d-flex.flex-column.justify-content-center.h-100
          .row
            .col-md-72.offset-md-36
              .row
                .col-md-120.offset-md-12.col-lg-88.offset-lg-28.col-xl-72.offset-xl-36
                  .card
                    .card-body
                      LogoLarge.text-center.mb-4
                      slot
</template>

<script lang="ts">
import Vue from 'vue'
import LogoLarge from './logo/LogoLarge.vue'
import PublicWrapper from './PublicWrapper.vue'

export default Vue.extend({
  components: {
    LogoLarge,
    PublicWrapper
  }
})
</script>
