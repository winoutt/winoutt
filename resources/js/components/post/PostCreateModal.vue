<template lang="pug">
  .modal-wrapper
    Modal#post-create-modal(title="Create a new post")
      template(v-slot:body)
        .text-area-wrapper.mb-3(
          :data-value="post.caption"
          v-max-character="500"
        )
          textarea.textarea-autosize.d-block.border-0.w-100(
            :placeholder="team.placeholder"
            v-model="post.caption"
            @input="suggestMentions()"
            :ref="reference"
            dir="auto"
            @keydown.esc="clearMentionBox()"
            @blur="clearMentionBox()"
          )
        .content-viewer
          Content(:post="post" type="small" :readMore="false")
          Loading.mt-2(text="Uploading..." v-if="isUploading")
      template(v-slot:footer)
        .row.footer.align-items-center
          .col-94.col-sm-114
            .content-upload.d-flex.align-items-center
              CommentMentionbox(:users="suggestedMentions" @choose="addMention")
              Icon.icon-hashtag.mr-2.mr-sm-3.cursor-pointer(name="hashtag" @click.native="addHashtag()")
              Icon.icon-photo.mr-2.mr-sm-3.cursor-pointer(name="photo" @click.native="clickOnInput('Image')")
              input#postImageInput(
                hidden
                type="file"
                accept="image/png, image/jpeg"
                multiple="multiple"
                @change="upload($event, 'image')"
              )
              Icon.icon-video.mr-2.mr-sm-3.cursor-pointer(name="video" @click.native="clickOnInput('Video')")
              input#postVideoInput(hidden type="file" accept="video/mp4" @change="upload($event, 'video')")
              Icon.icon-music.mr-2.mr-sm-3.cursor-pointer(name="music" @click.native="clickOnInput('Audio')")
              input#postAudioInput(hidden type="file" accept="audio/mp3, .wav" @change="upload($event, 'audio')")
              Icon.icon-file.mr-2.mr-sm-3.cursor-pointer(name="file" @click.native="clickOnInput('Document')")
              input#postDocumentInput(hidden type="file" accept="*" @change="upload($event, 'document')")
              Icon.icon-poll.cursor-pointer.mr-2.mr-sm-3(name="poll" @click.native="openPollCreateModal()")
              Icon.icon-article.cursor-pointer.mr-2.mr-sm-3.d-block.d-sm-none(name="writing" @click.native="openArticleWriteModal()")
              .article.cursor-pointer.text-primary.mr-2.mr-sm-3.d-none.d-sm-block(@click="openArticleWriteModal()") {{ articleText }}
          .col-50.col-sm-30
            .d-flex.justify-content-end
              Button.button.align-self-center(text="Post" @click.native="createPost()" :disabled="isCreating")
    ArticleWriteModal(@input="updateArticle" :content="bindArticleContent")
    PollCreateModal(@input="updatePoll" :content="bindPollContent")
    PostDiscardConfirmModal(@discard="discardPost()")
</template>

<script lang="ts">
import Vue from 'vue'
import { isEmpty, every, map, debounce, size, reverse, replace } from 'lodash'
import v from 'voca'
import UploadService from '../../services/UploadService'
import PostModalService from '../../services/ModalServices/PostModalService'
import ArticleModalService from '../../services/ModalServices/ArticleModalService'
import PollModalService from '../../services/ModalServices/PollModalService'
import TeamState from '../../State/TeamState'
import PostRequest from '../../Request/PostRequest'
import Mention from '../../services/Mention'
import Media from '../../services/Media'
import UserState from '../../State/UserState'
import PostMentionRequest from '../../Request/PostMentionRequest'
import maxCharacter from '../../directives/maxCharacter'
import Autosize from '../../services/Autosize'
import PostState from '../../State/PostState'

import Content from '../Content.vue'
import Modal from '../modal/Modal.vue'
import Icon from '../Icon.vue'
import Button from '../button/Button.vue'
import ArticleWriteModal from '../article/ArticleWriteModal.vue'
import PollCreateModal from '../poll/PollCreateModal.vue'
import PostDiscardConfirmModal from './PostDiscardConfirmModal.vue'
import CommentMentionbox from '../comment/CommentMentionbox.vue'
import Loading from '../Loading.vue'

export default Vue.extend({
  components: {
    Content,
    Modal,
    Icon,
    Button,
    ArticleWriteModal,
    PollCreateModal,
    PostDiscardConfirmModal,
    CommentMentionbox,
    Loading
  },

  directives: {
    maxCharacter
  },

  computed: {
    team () {
      return TeamState.collectTeam()
    },
    bindArticleContent () {
      return this.post.content.type === 'article' ? this.post.content.body : ''
    },
    bindPollContent () {
      return this.post.poll.question ? this.post.poll : ''
    },
    suggestedMentions () {
      return UserState.collectPostMentions()
    },
    articleText () {
      const quillContent = PostState.collectArticleEditorContent()
      return quillContent ? 'Edit article' : 'Write an article'
    }
  },

  data () {
    return {
      reference: 'post-create-modal',
      post: {
        caption: '',
        content: {
          type: 'text',
          body: '',
          cover: '',
          extension: '',
          filename: null
        },
        poll: {
          question: '',
          choices: [],
          end_at: ''
        },
        album: []
      },
      isDiscarded: false,
      isUploading: false,
      isCreating: false
    }
  },

  methods: {
    addHashtag () {
      if (this.isCreating) return
      this.post.caption = this.post.caption + ' #'
      this.$refs[this.reference].focus()
    },
    clickOnInput (type) {
      if (this.isCreating) return
      this.clear(false)
      const inputDom = document.getElementById(`post${type}Input`)
      inputDom.click()
    },
    async upload (event, type) {
      const updatePost = file => {
        this.post.content.type = type
        this.post.content.body = file.uri
        this.post.content.extension = file.extension
        this.post.content.filename = file.name
      }
      if (type === 'image') {
        const photos = await UploadService.fileMultiple(event)
        if (!Media.isValidPhotos(photos)) return
        if (isEmpty(photos)) return
        const type = size(photos) === 1 ? 'image' : 'album'
        if (type === 'image') updatePost(photos[0])
        else {
          this.post.content.type = 'album'
          this.post.album = map(photos, photo => {
            return {
              photo: photo.uri,
              filename: photo.name,
              extension: photo.extension
            }
          })
        }
      } else {
        const file = await UploadService.file(event)
        if (type === 'video' && !Media.isValidVideo(file)) return
        if (type === 'audio' && !Media.isValidAudio(file)) return
        if (type === 'document' && !Media.isValidDocument(file)) return
        updatePost(file)
      }
    },
    clear (clearCaption = true) {
      const caption = clearCaption ? '' : this.post.caption
      this.post = {
        caption,
        content: {
          type: 'text',
          body: '',
          cover: '',
          extension: '',
          filename: null
        },
        poll: {
          question: '',
          choices: [],
          end_at: ''
        },
        album: []
      }
      this.isDiscarded = false
    },
    onClosing () {
      PostModalService.create().onClosing(event => {
        const { content: { body }, poll: { question }, caption, album } = this.post
        const contents = [body, question, caption, album]
        const hasNoContent = every(contents, content => isEmpty(content))
        const canShowDiscardModal = !this.isDiscarded && !hasNoContent
        if (canShowDiscardModal) {
          event.preventDefault()
          PostModalService.discardConfirm().open()
        }
      })
    },
    openPollCreateModal () {
      if (this.isCreating) return
      this.clear(false)
      PollModalService.create().open()
    },
    openArticleWriteModal () {
      if (this.isCreating) return
      this.clear(false)
      ArticleModalService.write().open()
    },
    updateArticle (article) {
      const { body, cover, extension } = article
      this.post.content.type = 'article'
      this.post.content.body = body
      this.post.content.cover = cover
      this.post.content.extension = extension
    },
    updatePoll (poll) {
      this.post.content.type = 'poll'
      this.post.poll = poll
    },
    discardPost () {
      this.isDiscarded = true
      PostModalService.create().close()
      PostState.clearArticleEditor()
      this.clear()
      this.$nextTick(() => Autosize.reset())
    },
    async createPost () {
      const { caption, content, poll } = this.post
      const { type, body, extension, cover, filename } = content
      const { question, choices, end_at: endAt } = poll
      var post = {}
      if (type === 'text') {
        post = {
          teamId: this.team.id,
          type,
          caption
        }
      } else if (type === 'article') {
        post = {
          teamId: this.team.id,
          type,
          body,
          cover,
          extension,
          caption
        }
      } else if (type === 'poll') {
        post = {
          teamId: this.team.id,
          type,
          caption,
          question,
          choices: map(choices, choice => choice.value),
          endAt
        }
      } else if (type === 'album') {
        this.isUploading = true
        post = {
          teamId: this.team.id,
          type,
          caption,
          photos: map(this.post.album, photo => {
            return {
              file: photo.photo,
              extension: photo.extension,
              filename: photo.filename
            }
          })
        }
      } else {
        this.isUploading = true
        post = {
          teamId: this.team.id,
          type,
          body,
          extension,
          filename,
          caption
        }
      }
      this.isCreating = true
      const response = await PostRequest.create(post)
      this.isUploading = false
      this.isCreating = false
      if (isEmpty(response)) return
      this.clear()
      this.$nextTick(() => Autosize.reset())
      PostModalService.create().close()
      PostState.clearArticleEditor()
    },
    suggestMentions: debounce(async function () {
      const isMention = Mention.isLastWordIsMention(this.post.caption)
      if (!isMention) return UserState.replacePostMentions([])
      const term = Mention.getTerm(this.post.caption)
      isEmpty(term)
        ? await PostMentionRequest.suggestions()
        : await PostMentionRequest.searchSuggestions(term)
    }, 300),
    addMention (user) {
      const lastMention = Mention.lastMention(this.post.caption)
      if (lastMention === '@') {
        this.post.caption = v.reverse(
          v.replace(v.reverse(this.post.caption), '@', v.reverse(`@${user.username} `))
        )
      } else this.post.caption = v.replace(this.post.caption, lastMention, `@${user.username} `)
      UserState.replacePostMentions([])
      this.$refs[this.reference].focus()
    },
    clearMentionBox () {
      setTimeout(() => {
        UserState.replacePostMentions([])
      }, 300)
    },
    initAutosize () {
      Autosize.boot()
    }
  },

  mounted () {
    this.onClosing()
    this.initAutosize()
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

textarea
  resize: none
  outline: none

.footer
  .article
    font-weight: 500
  .content-upload
    .icon
      width: 19px
      height: 19px
      fill: $secondary

@media (max-width: 576px)
  .footer
    .content-upload
      .icon
        width: 17px
        height: 17px
</style>
