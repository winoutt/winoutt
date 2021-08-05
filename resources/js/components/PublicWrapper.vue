<template lang="pug">
  .d-flex.flex-column.justify-content-between.h-100
    .mt-5(:class="setHeight")
      slot
    Footer.text-center.m-auto
</template>

<script lang="ts">
import Vue from 'vue'
import Footer from './Footer.vue'

export default Vue.extend({
  props: ['fixedHeight'],
  components: {
    Footer
  },

  computed: {
    setHeight () {
      return this.fixedHeight ? 'h-100' : ''
    }
  }
})
</script>
