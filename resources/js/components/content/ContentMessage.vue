<template lang="pug">
  .content-message
    YouTubePlayer(:content="message.content" v-if="isType('text')")
    ContentLinkPreview(:linkPreview="message.link_preview" v-if="message.link_preview")
    .text(v-if="isType('text')") {{ message.content }}
    .image(v-else-if="isType('image')")
      img.cursor-pointer(:src="message.content" @click="showLightbox()")
    .video(v-else-if="isType('video')")
      video(controls muted)
        source(:src="message.content")
    .audio(v-else-if="isType('audio')")
      audio(controls muted)
        source(:src="message.content")
    .document(v-else-if="isType('document')")
      a.d-flex.align-items-center(:href="message.content" target="_blank" download)
        span.mr-2 {{ message.filename }}
        Icon.icon-download(name="download")
    Lightbox(:media="message.photo_original" :canShow="canShowLightBox" @hide="canShowLightBox = false")
</template>

<script lang="ts">
import Vue from 'vue'

import YouTubePlayer from '../YouTubePlayer.vue'
import ContentLinkPreview from './ContentLinkPreview.vue'
import Icon from '../Icon.vue'
import Lightbox from '../Lightbox.vue'

export default Vue.extend({
  props: {
    message: { type: Object }
  },

  components: {
    YouTubePlayer,
    ContentLinkPreview,
    Icon,
    Lightbox
  },

  data () {
    return {
      canShowLightBox: false
    }
  },

  methods: {
    showLightbox () {
      this.canShowLightBox = true
    },
    isType (type) {
      return this.message.type === type
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

.content-message
  img
    height: 150px
    object-fit: cover
    background: lighten($grey, 15%)
  video, audio
    outline: none
  img, video, audio
    border-radius: 8px
    width: 250px
  .document
    .icon-download
      width: 15px
      height: 15px
      fill: $primary

@media (max-width: 992px)
  .content-message
    img, video, audio
      width: 200px
</style>
