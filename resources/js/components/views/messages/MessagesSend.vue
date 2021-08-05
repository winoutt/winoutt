<template lang="pug">
  .messages-send.d-flex.justify-content-between
    .textarea-wrapper.w-100.pr-1(
      :data-value="message"
      v-max-character="1000"
    )
      textarea.textarea-autosize.d-block.rounded.px-2.py-1.w-100.mr-3.scroll(placeholder="Write your message…" rows="1" v-model="message" @keydown.enter.exact.prevent="sendText()" @focus="scrollMessagesToBottom()")
    input#mediaSendInput(hidden @change="sendFile" type="file")
    Icon.icon-attach.cursor-pointer.mr-3(name="attach" @click.native="clickOnInput()")
    Icon.icon-send.cursor-pointer(name="send" @click.native="sendText()")
</template>

<script lang="ts">
import Vue from 'vue'
import { isEmpty, trim } from 'lodash'
import UploadService from '../../../services/UploadService'
import Media from '../../../services/Media'
import MessageRequest from '../../../Request/MessageRequest'

import Textarea from '../../Textarea.vue'
import Icon from '../../Icon.vue'
import ChatState from '../../../State/ChatState'
import Autosize from '../../../services/Autosize'
import maxCharacter from '../../../directives/maxCharacter'
import MessageScroll from '../../../Scroll/MessageScroll'

export default Vue.extend({
  components: {
    Textarea,
    Icon
  },

  directives: {
    maxCharacter
  },

  computed: {
    chat () {
      return ChatState.collectChat()
    }
  },

  data () {
    return {
      message: ''
    }
  },

  methods: {
    clickOnInput () {
      const mediaSendInput = document.getElementById('mediaSendInput')
      mediaSendInput.click()
    },
    async send (data) {
      const message = await MessageRequest.create(data)
      return message
    },
    async sendFile (event) {
      const file = await UploadService.file(event)
      const isValidFile = Media.isValidFile(file)
      if (!isValidFile) return
      const data = {
        chatId: this.chat.pivot.id,
        type: Media.type(file),
        file: file.uri,
        filename: file.name,
        extension: file.extension
      }
      this.send(data)
    },
    async sendText () {
      const message = trim(this.message)
      if (isEmpty(message)) return
      const data = {
        chatId: this.chat.pivot.id,
        type: 'text',
        message
      }
      const messageData = await this.send(data)
      if (!messageData) return
      this.message = ''
      this.$nextTick(() => Autosize.reset())
    },
    initAutosize () {
      Autosize.boot()
    },
    scrollMessagesToBottom () {
      setTimeout(() => {
        MessageScroll.toBottom()
      }, 100)
    }
  },

  mounted () {
    this.initAutosize()
  }
})
</script>

<style lang="sass" scoped>
.messages-send
  background: #f1f1f1
  padding: 12px 25px
  border-radius: 8px
  max-height: 200px
  margin-bottom: 20px
  textarea
    background: #f1f1f1
    border: none
    outline: none
    resize: none
    max-height: 181px
    margin-bottom: 5px
  .icon-attach
    width: 15px
    height: 22px
    margin-top: 6px
  .icon-send
    width: 22px
    height: 22px
    margin-top: 6px
</style>
