<template lang="pug">
  .content(:class="typeClass")
    .text(v-if="isType('text')") {{ post.content.body }}
    .image(v-else-if="isType('image')")
      img.cursor-pointer(:src="post.content.body" @click="showLightbox()")
    PostPhotoAlbum.album(v-else-if="isType('album')" :post="post")
    .video(v-else-if="isType('video')")
      video(controls muted)
        source(:src="post.content.body")
    .audio(v-else-if="isType('audio')")
      audio(controls muted)
        source(:src="post.content.body")
    .document(v-else-if="isType('document')")
      a.d-flex.align-items-center(:href="post.content.body" target="_blank" download)
        span.mr-2 {{ post.content.filename }}
        Icon.icon-download(name="download")
    .article.position-relative(v-else-if="isType('article')")
      img.cover(:src="post.content.cover" v-if="post.content.cover")
      .article-content(v-html="post.content.body" dir="auto")
      .read-more.position-absolute.bg-white.text-center
        Button.read-more-button.mt-2.rounded-pill(text="Read more" :secondary="true" @click.native="read(post)" v-if="readMore")
    Poll(v-else-if="isType('poll')" :post="post")
    Lightbox(v-if="post.content" :media="post.content.photo_original || post.content.body" :canShow="canShowLightBox" @hide="canShowLightBox = false")
</template>

<script lang="ts">
import Vue from 'vue'
import { size } from 'lodash'
import ArticleModalService from '../services/ModalServices/ArticleModalService'
import PostState from '../State/PostState'

import Icon from './Icon.vue'
import Button from './button/Button.vue'
import Poll from './poll/Poll.vue'
import Lightbox from './Lightbox.vue'
import PostPhotoAlbum from './post/PostPhotoAlbum.vue'

export default Vue.extend({
  props: {
    post: { type: Object },
    type: { type: String },
    readMore: { default: true }
  },

  components: {
    Icon,
    Button,
    Poll,
    Lightbox,
    PostPhotoAlbum
  },

  computed: {
    typeClass () {
      const isSmall = this.type === 'small'
      const isLarge = this.type === 'large'
      return isSmall ? 'content-small' : isLarge ? 'content-large' : ''
    }
  },

  data () {
    return {
      canShowLightBox: false
    }
  },

  methods: {
    read (post) {
      PostState.replacePost(post)
      this.$nextTick(function () {
        ArticleModalService.read().open()
      })
    },
    showLightbox () {
      this.canShowLightBox = true
    },
    isType (type) {
      if (this.post.poll && this.post.poll.question) return (type === 'poll')
      else if (size(this.post.album)) return (type === 'album')
      else if (this.post.content) return (this.post.content.type === type)
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../sass/variables'

.content
  img
    object-fit: contain
  video, audio
    outline: none
  img, video, audio
    border-radius: 8px
  .document
    .icon-download
      width: 15px
      height: 15px
      fill: $primary
  .article
    .article-content
      max-height: 175px
      overflow: hidden
    .read-more
      box-shadow: 0px -14px 20px 3px #ffffff
      z-index: 1
      width: 100%
      bottom: 0
      .read-more-button
        padding: 8.8px 16px
    .cover
      height: 175px
      object-fit: cover
      width: 100%
  &.content-small
    img, video, audio
      max-width: 275px
      max-height: 275px
  &.content-large
    img, video, audio
      max-width: 100%
      max-height: 350px
</style>
