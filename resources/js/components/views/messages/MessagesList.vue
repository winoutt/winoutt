<template lang="pug">
  #messages-wrapper.messages-list.scroll
    #messages
      .message-group(v-for="messageGroup, day in messageGroups")
        .day-wrapper.d-flex.align-items-center.my-2
          .line.w-100
          small.day.mx-2.text-secondary {{ day }}
          .line.w-100
        .message-wrapper.w-auto.d-table.mb-4(v-for="message in messageGroup" :class="message.is_sent ? 'message-sent' : 'message-received'" :key="message.id")
          .message
            .message-details.d-flex.align-items-center
              AvatarSmall(:user="user" v-if="message.is_sent")
              AvatarSmall(:user="chat" v-else)
              .details.d-flex.mx-2
                FullName.name.font-weight-bold(v-if="message.is_sent") You
                FullName.name.font-weight-bold(v-else) {{ chat.full_name }}
                small.time.mx-2 {{ Humanize.fromNow(message.created_at) }}
                .status(v-if="message.is_sent")
                  .sent(v-if="message.status === 'sent'")
                    Icon.icon-check.mr-1.d-flex(name="check")
                  .delivered(v-else-if="message.status === 'delivered'")
                    Icon.icon-double-check.mr-1.d-flex(name="double-check")
                  .read(v-else-if="message.status === 'read'")
                    Icon.icon-double-check.mr-1.d-flex.read(name="double-check")
            .message-content.d-flex
              .avatar-space
              ContentMessage.mx-2(:message="message")
</template>

<script lang="ts">
import Vue from 'vue'
import MessageState from '../../../State/MessageState'
import UserState from '../../../State/UserState'
import MessageScroll from '../../../Scroll/MessageScroll'

import AvatarSmall from '../../avatar/AvatarSmall.vue'
import Icon from '../../Icon.vue'
import ContentMessage from '../../content/ContentMessage.vue'
import FullName from '../../FullName.vue'

export default Vue.extend({
  props: ['chat'],
  components: {
    AvatarSmall,
    Icon,
    ContentMessage,
    FullName
  },

  computed: {
    user () {
      return UserState.collectUser()
    },
    messageGroups () {
      const messages = MessageState.collectMessages()
      return this.Util.groupByDate(messages)
    }
  },

  methods: {
    scrollToBottom () {
      MessageScroll.toBottom()
    }
  },

  beforeDestroy () {
    MessageScroll.paginate.leave()
  },

  mounted () {
    this.scrollToBottom()
    MessageScroll.paginate.listen()
  }
})
</script>

<style lang="sass" scoped>
@import '../../../../sass/variables'

.messages-list
  padding-right: 4px
  height: inherit
  .day-wrapper
    .line
      height: 1px
      background: #ddd
    .day
      white-space: nowrap
  .message-wrapper
    max-width: 70%
    .message-content
      justify-content: end
      .avatar-space
        width: 40px
    .details
      align-items: baseline
      .time
        font-size: 0.75rem
        white-space: nowrap
    &.message-sent
      margin-left: auto
      .message-details
        flex-direction: row-reverse
      .details
        display: flex
        justify-content: flex-end
        align-items: center
        .name
          align-self: baseline
        .status
          .icon-check
            width: 12px
            height: 10px
          .icon-double-check
            width: 16px
            height: 10px
          .read
            fill: $primary
      .message-content
        flex-direction: row-reverse
        justify-content: start
</style>
