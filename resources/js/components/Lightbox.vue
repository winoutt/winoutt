<template lang="pug">
  transition(name="fade")
    .lightbox.position-fixed.d-flex.align-items-center.justify-content-center.h-100.w-100.cursor-pointer(:class="canShowLightbox ? 'show' : ''" @click="hideLightbox()" v-if="canShowLightbox")
      .image-wrapper.position-relative
        img(:src="media")
        .close-text.position-absolute.font-weight-bold.text-white.cursor-pointer Close
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: ['media', 'canShow'],
  data () {
    return {
      canShowLightbox: this.canShow
    }
  },

  watch: {
    canShow: function (newValue) {
      this.canShowLightbox = newValue
    }
  },

  methods: {
    hideLightbox () {
      this.$emit('hide')
    }
  }
})
</script>

<style lang="sass" scoped>
.lightbox
  top: 50%
  left: 50%
  transform: translate(-50%, -50%)
  background: rgba(#000, 0.5)
  z-index: 1051
  img
    max-width: 90vw
    max-height: 90vh
    object-fit: contain
  .close-text
    top: 10px
    right: 20px
    text-shadow: 0 0 5px #000
  .image-wrapper
    background: #000
</style>
