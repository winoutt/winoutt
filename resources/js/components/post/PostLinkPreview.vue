<template lang="pug">
.post-preview(v-if="canShow" :class="position")
  YouTubePlayer(:content="post.caption")
  ContentLinkPreview(v-if="post.link_preview" :linkPreview="post.link_preview")
</template>

<script lang="ts">
import Vue from 'vue'
import Url from '../../services/Url'
import YouTubePlayer from '../YouTubePlayer.vue'
import ContentLinkPreview from '../content/ContentLinkPreview.vue'

export default Vue.extend({
  props: ['post', 'position'],

  components: {
    YouTubePlayer,
    ContentLinkPreview
  },

  computed: {
    canShow () {
      const { caption, link_preview: linkPreview } = this.post
      const urlPostion = Url.getUrlPosition(caption, linkPreview)
      return urlPostion === this.position
    }
  }
})
</script>

<style lang="sass" scoped>
.post-preview
  &.top
    margin-bottom: 15px
  &.bottom
    margin-top: 15px
</style>
