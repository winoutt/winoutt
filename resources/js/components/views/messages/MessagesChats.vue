<template lang="pug">
  .messages-chats-wrapper.scroll(:id="`chats-wrapper`" v-if="!isEmpty(chats)")
    .messages-chats(:id="`chats`")
      .messages-chat.d-flex.justify-content-between.cursor-pointer.px-2.chat-hover(
        v-for="chat in chats"
        :key="chat.id"
        :class="[activeChat.id === chat.id ? 'active-chat' : '', chat.unreads_count ? 'new-message' : '']"
        @click="replaceChat(chat)"
      )
        .chat.d-flex.w-100
          AvatarSmall.mr-2(:user="chat")
          .main.d-flex.flex-column.justify-content-between.w-100.text-truncate
            .header.d-flex.justify-content-between
              FullName.font-weight-bold {{ chat.full_name }}
              small.time(v-if="chat.last_message") {{ Humanize.fromNow(chat.last_message.created_at) }}
              Icon.icon-archive(name="archive" v-if="canArchive(chat)" @click.native.stop="archiveChat(chat)")
              Icon.icon-unarchive(name="unarchive" v-else-if="canUnarchive(chat)" @click.native.stop="unarchiveChat(chat)")
            .footer.d-flex.justify-content-between.align-items-center
              template(v-if="chat.last_message")
                small.text-truncate(v-if="chat.last_message.type === 'text'") {{ chat.last_message.content }}
                small(v-else) {{ capitalize(chat.last_message.type) }}
              Indicator(:canShow="tab === 'active' && chat.unreads_count")
  .not-found.text-center.mt-5(v-else)
    Icon.icon-conversation.mb-2(name="conversation")
    h5.font-weight-bold No messages
    p.text-secondary Your conversations will appear here.
</template>

<script lang="ts">
import Vue from 'vue'
import $ from 'jquery'
import { isEmpty, capitalize } from 'lodash'
import ChatState from '../../../State/ChatState'
import ChatRequest from '../../../Request/ChatRequest'
import MessageRequest from '../../../Request/MessageRequest'
import MessageScroll from '../../../Scroll/MessageScroll'
import ChatScroll from '../../../Scroll/ChatScroll'

import AvatarSmall from '../../avatar/AvatarSmall.vue'
import Icon from '../../Icon.vue'
import Indicator from '../../Indicator.vue'
import FullName from '../../FullName.vue'

export default Vue.extend({
  components: {
    AvatarSmall,
    Icon,
    Indicator,
    FullName
  },

  computed: {
    isEmpty () {
      return isEmpty
    },
    capitalize () {
      return capitalize
    },
    tab () {
      return ChatState.collectTab()
    },
    chats () {
      return this.tab === 'active' ? ChatState.collectActive() : ChatState.collectArchived()
    },
    activeChat () {
      return ChatState.collectChat()
    },
    queryUserId () {
      return this.$route.query.user
    }
  },

  watch: {
    queryUserId () {
      this.activateChat()
    }
  },

  methods: {
    archiveChat (chat) {
      ChatRequest.archive(chat)
    },
    unarchiveChat (chat) {
      ChatRequest.unarchive(chat)
    },
    replaceChat (chat) {
      const requests = [
        MessageRequest.paginate(chat.pivot.id),
        ChatRequest.read(chat.pivot.id)
      ]
      Promise.all(requests).then(() => {
        ChatState.replaceChat(chat)
        this.$nextTick(() => {
          MessageScroll.toBottom()
          $('.messages-send textarea').focus()
        })
      })
    },
    async activateChat () {
      const userId = this.queryUserId
      if (!userId) return
      const chat = await ChatRequest.readFromUserId(userId)
      if (isEmpty(chat)) return
      this.replaceChat(chat)
    },
    canArchive (chat) {
      const isActiveTab = (this.tab === 'active')
      return isActiveTab && chat.last_message
    },
    canUnarchive (chat) {
      const isActiveTab = (this.tab === 'active')
      return !isActiveTab && chat.last_message
    }
  },

  beforeDestroy () {
    ChatScroll.paginate.leave()
  },

  mounted () {
    ChatScroll.paginate.listen()
    this.activateChat()
  }
})
</script>

<style lang="sass" scoped>
@import '../../../../sass/variables'

.messages-chats-wrapper
  height: calc(100% - 137px)
  padding-right: 4px
  .messages-chat
    border-radius: 8px
    transition: 0.4s
    padding-top: 14px
    padding-bottom: 14px
    .chat
      .header
        .time
          white-space: nowrap
          font-size: 0.75rem
        .icon-archive, .icon-unarchive
          width: 13px
          height: 13px
          display: none
      .footer
        small
          font-size: 0.75rem
    &.active-chat
      background: #E5E5ED
    &.new-message
      background: #ebedf6
    &.chat-hover
      &:hover
        background: #f1f1f5
        .header
          .time
            display: none
          .icon-archive, .icon-unarchive
            display: block

.not-found
  .icon-conversation
    width: 40px
    height: 40px
</style>
