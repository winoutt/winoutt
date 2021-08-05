<template lang="pug">
.post-photo-album
  .photos.position-relative.cursor-pointer(:class="photosCountClass")
    img(v-for="photo in previews" :src="photo.photo" @click="showSlider(photo)")
    .view-photos.d-flex.align-items-center.position-absolute.rounded-pill.bg-primary.text-white.px-3.py-2(@click="showSlider()")
      Icon.icon-eye.mr-2(name="eye")
      | {{ post.album.length }} photos
</template>

<script lang="ts">
import Vue from 'vue'
import { size, take } from 'lodash'

import Icon from '../Icon.vue'
import Slider from '../../services/Slider'

export default Vue.extend({
  props: ['post'],
  components: {
    Icon
  },

  computed: {
    photosCountClass () {
      const count = size(this.post.album)
      return count === 2 ? 'col-two' : count === 3 ? 'col-three' : count >= 4 ? 'col-four' : ''
    },
    previews () {
      return take(this.post.album, 4)
    }
  },

  methods: {
    showSlider (chosePhoto = null) {
      Slider.show(this.post.album, chosePhoto)
    }
  }
})
</script>

<style lang="sass" scoped>
.post-photo-album
  .photos
    height: 250px
    img
      object-fit: cover
      float: left
    &.col-two
      img
        width: 50%
        height: 100%
        &:nth-child(1)
          border-top-left-radius: 4px
          border-bottom-left-radius: 4px
        &:nth-child(2)
          border-top-right-radius: 4px
          border-bottom-right-radius: 4px
    &.col-three
      img
        width: 50%
        height: 50%
        &:nth-child(1)
          border-top-left-radius: 4px
        &:nth-child(2)
          border-top-right-radius: 4px
        &:nth-child(3)
          width: 100%
          border-bottom-left-radius: 4px
          border-bottom-right-radius: 4px
    &.col-four
      img
        width: 50%
        height: 50%
        &:nth-child(1)
          border-top-left-radius: 4px
        &:nth-child(2)
          border-top-right-radius: 4px
        &:nth-child(3)
          border-bottom-left-radius: 4px
        &:nth-child(4)
          border-bottom-right-radius: 4px
    .view-photos
      visibility: hidden
      opacity: 0
      transition: all 0.4s
      top: 50%
      left: 50%
      transform: translate(-50%, -50%)
      .icon-eye
        width: 19px
        height: 14px
        fill: white
    &:hover
      .view-photos
        visibility: visible
        opacity: 1
</style>
