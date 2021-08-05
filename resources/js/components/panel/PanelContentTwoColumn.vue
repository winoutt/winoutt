<template lang="pug">
.row
  .col-md-72.offset-md-2.col-lg-89.offset-lg-1.col-xl-94.offset-xl-4.wrapper
    HeadingSmall.my-3(v-if="heading") {{ heading }}
    slot
  .col-md-70.col-lg-54.col-xl-43.offset-xl-3
    .sticky-top
      Aside
</template>

<script lang="ts">
import Vue from 'vue'

import Aside from '../aside/Aside.vue'

export default Vue.extend({
  props: ['heading'],

  components: {
    Aside
  }
})
</script>

<style lang="sass" scoped>
.sticky-top
  top: -350px // To fix the content stick on top, not scrolling to bottom

@media (max-width: 767px)
  .wrapper
    min-height: calc(100vh - 223px)
</style>
