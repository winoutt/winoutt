<template lang="pug">
.modal-wrapper
  ModalLarge#article-write-modal(:custom-close="true")
    <template v-slot:custom-close>
      <ArticleGoBackToFeed :can-discard-confirm="canDiscard"/>
    </template>
    template(v-slot:header-content)
      h5.modal-title Write an article
    template(v-slot:body)
      .row
        .col-md-82.offset-md-31
          .article-write-body
            InputImage.article-cover.mx-auto.mb-3(@change="updateCover" text="cover" v-model="cover")
            .title-wrapper.d-flex.align-items-end(
              :data-value="title"
              v-max-character="120"
            )
              input.title.mb-2.w-100(
                placeholder="Title"
                v-model="title"
                dir="auto"
              )
            #articleEditor(dir="auto")
    template(v-slot:footer)
      .footer.d-flex.align-items-center
        #toolbar.d-flex
          span.ql-formats
            button.ql-bold Bold
            button.ql-italic Italic
            button.ql-underline Underline
            button.ql-strike Strike
          span.ql-formats
            button.ql-list(value="ordered")
            button.ql-list(value="bullet")
          span.ql-formats
            button.ql-link
            button.ql-image
        Button.publish-button.ml-auto(
          text="Publish"
          @click.native="publish()"
          :disabled="!canCreate"
        )
  ArticleDiscardConfirmModal(@discard="discardArticle()")
</template>

<script lang="ts">
import Vue from 'vue'
import Quill from 'quill'
import { stripTags } from 'voca'
import ArticleModalService from '../../services/ModalServices/ArticleModalService'
import QuillService from '../../services/Quill'
import Validate from '../../services/Validate'
import maxCharacter from '../../directives/maxCharacter'

import ModalLarge from '../modal/ModalLarge.vue'
import InputImage from '../input/InputImage.vue'
import Button from '../button/Button.vue'
import ArticleGoBackToFeed from './ArticleGoBackToFeed.vue'
import ArticleDiscardConfirmModal from './ArticleDiscardConfirmModal.vue'
import PostState from '../../State/PostState'

export default Vue.extend({
  props: ['content'],
  components: {
    ModalLarge,
    InputImage,
    Button,
    ArticleGoBackToFeed,
    ArticleDiscardConfirmModal
  },

  directives: {
    maxCharacter
  },

  data () {
    return {
      extension: ''
    }
  },

  watch: {
    quillContent () {
      Validate.articleContentMaxCharacters(this.quillContent)
    }
  },

  computed: {
    canCreate () {
      const content = stripTags(this.quillContent)
      const isTitleExceeded = this.title.length > 120
      const isContentExceeded = Validate.isArticleContentMaxCharactersExceeded(this.quillContent)
      return this.title && content && !isTitleExceeded && !isContentExceeded
    },
    canDiscard () {
      const content = this.quillContent
      return this.title || content || this.cover
    },
    cover: {
      get: () => PostState.collectArticleEditorCover(),
      set: cover => PostState.replaceArticleEditorCover(cover)
    },
    title: {
      get: () => PostState.collectArticleEditorTitle(),
      set: title => PostState.replaceArticleEditorTitle(title)
    },
    quillContent: {
      get: () => PostState.collectArticleEditorContent(),
      set: content => PostState.replaceArticleEditorContent(content)
    },
    quillEditor: {
      get: () => PostState.collectArticleEditorQuillEditor(),
      set: editor => PostState.replaceArticleEditorQuillEditor(editor)
    }
  },

  methods: {
    initQuill () {
      QuillService.link()
      const container = document.getElementById('articleEditor')
      const options = {
        modules: {
          toolbar: '#toolbar'
        },
        placeholder: 'Tell your story…',
        theme: 'snow'
      }
      this.quillEditor = new Quill(container, options)
      this.quillEditor.on('text-change', (delta, oldDelta, source) => {
        this.quillContent = this.quillEditor.root.innerHTML
      })
    },
    generateContent () {
      if (!this.quillEditor) return
      const content = `<h1>${this.title}</h1>${this.quillContent}`
      return content
    },
    publish () {
      const article = {
        body: this.generateContent(),
        cover: this.cover,
        extension: this.extension
      }
      this.$emit('input', article)
      ArticleModalService.write().close()
    },
    updateCover (file) {
      this.cover = file.uri
      this.extension = file.extension
    },
    discardArticle () {
      PostState.clearArticleEditor()
      ArticleModalService.write().close()
    },
    restoreContent () {
      this.quillEditor.root.innerHTML = this.quillContent
    },
    onOpen () {
      ArticleModalService.write().onOpen(() => {
        this.restoreContent()
      })
    }
  },

  mounted () {
    this.initQuill()
    this.onOpen()
  }
})
</script>

<style lang="sass" scoped>
.article-write-body
  height: calc(100vh - 203px)
  .article-cover
    width: 100%
    height: 270px
  .title
    outline: none
    border: none
    background: transparent
    font-size: 1.5rem
    margin-bottom: 10px

.footer
  #toolbar
    padding: 0
</style>
