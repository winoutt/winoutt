<template lang="pug">
  ModalLarge#article-read-modal(v-if="canShow" :footer="false" :custom-close="true")
    template(v-slot:custom-close)
      ArticleGoBackToFeed
    template(v-slot:header-content)
      .user.d-flex.align-items-center.text-truncate
        h5.modal-title.text-truncate.mr-2
          | Published by
          FullName  {{ post.user.full_name }}
    template(v-slot:body)
      .row
        .col-md-82.offset-md-31
          .article.article-large(dir="auto" ref="article" :direction="articleDirection")
            h1.title {{ title }}
            img.cover.mb-4.rounded(:src="post.content.cover_original" v-if="post.content.cover_original")
            .content(v-html="content")
</template>

<script lang="ts">
import Vue from 'vue'
import { indexOf, substring, replace, trim, count } from 'voca'
import PostState from '../../State/PostState'

import Icon from '../Icon.vue'
import ModalLarge from '../modal/ModalLarge.vue'
import FullName from '../FullName.vue'
import JobTitle from '../JobTitle.vue'
import ArticleGoBackToFeed from './ArticleGoBackToFeed.vue'
import ArticleModalService from '../../services/ModalServices/ArticleModalService'
import ArticleReadModalScroll from '../../Scroll/ArticleReadModalScroll'

export default Vue.extend({
  components: {
    Icon,
    ModalLarge,
    FullName,
    JobTitle,
    ArticleGoBackToFeed
  },

  data () {
    return {
      articleDirection: 'ltr'
    }
  },

  computed: {
    post () {
      return PostState.collectPost()
    },
    title () {
      const { body } = this.post.content
      const openTagIndex = indexOf(body, '<h1>')
      const closeTagIndex = indexOf(body, '</h1>')
      const titleWithOpenTag = substring(body, openTagIndex, closeTagIndex)
      const title = replace(titleWithOpenTag, '<h1>', '')
      return trim(title)
    },
    content () {
      const { body } = this.post.content
      const closeTagIndex = indexOf(body, '</h1>')
      const contentWithCloseTag = substring(body, closeTagIndex, count(body))
      const content = replace(contentWithCloseTag, '</h1>', '')
      return trim(content)
    },
    canShow () {
      return this.post && this.post.content && this.post.user
    }
  },

  methods: {
    setArticleDirection () {
      const element = this.$refs.article
      this.articleDirection = element
        ? window.getComputedStyle(element, null).direction
        : 'ltr'
    },
    onOpen () {
      ArticleModalService.read().onOpen(() => {
        ArticleReadModalScroll.toTop()
      })
    }
  },

  updated () {
    this.setArticleDirection()
  },

  mounted () {
    this.onOpen()
  }
})
</script>

<style lang="sass" scoped>
.user
  .title
    font-size: 0.85rem
.cover
  width: 100%
  height: 380px
  object-fit: cover
</style>

<style lang="sass">
#article-read-modal .article a
  color: #1A5FAA !important
</style>
