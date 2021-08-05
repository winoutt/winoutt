<template lang="pug">
  .photos-slider.position-fixed.w-100.h-100.d-flex.align-items-center.justify-content-center(v-if="canShowSlider")
    .slider
      #carouselExampleControls.carousel.slide.w-100.h-100(data-ride='carousel')
        .carousel-inner.w-100.h-100
          .carousel-item.w-100.h-100(
            v-for="(photo, index) in photos"
            :class="index === 0 ? 'active' : ''"
          )
            img.d-block.w-100.h-100(:src="photo.photo_original ? photo.photo_original : photo.photo")
        a.carousel-control-prev(
          href='#carouselExampleControls'
          role='button'
          data-slide='prev'
        )
          Icon.icon-chevron(name="chevron-left" aria-hidden='true')
        a.carousel-control-next(
          href='#carouselExampleControls'
          role='button'
          data-slide='next'
        )
          Icon.icon-chevron(name="chevron-right" aria-hidden='true')
      .close-text.position-absolute.font-weight-bold.text-white.cursor-pointer(
        @click.prevent.stop="hide()"
      ) Close
</template>

<script lang="ts">
import Vue from 'vue'
import Icon from './Icon.vue'

import SliderState from '../State/SliderState'
import Slider from '../services/Slider'

export default Vue.extend({
  components: {
    Icon
  },

  computed: {
    canShowSlider () {
      return SliderState.collectCanShow()
    },
    photos () {
      return SliderState.collectPhotos()
    }
  },

  methods: {
    hide () {
      Slider.hide()
    }
  }
})
</script>

<style lang="sass" scoped>
.photos-slider
  z-index: 1045
  top: 50%
  left: 50%
  transform: translate(-50%, -50%)
  background: rgba(#000, 0.5)
  .slider
    width: 90vw
    height: 90vh
    img
      object-fit: contain
    .close-text
      text-shadow: 0 0 5px #000
      top: 20px
      right: 20px
    .icon-chevron
      width: 18px
      height: 30px
      fill: #fff
</style>
