<template lang="pug">
.col-md-84.col-lg-94.h-100(v-if="hasChat")
  .messages-content.d-flex.justify-between.flex-column.h-100
    MessagesHeader(:chat="chat")
    MessagesList(:chat="chat")
    MessagesSend
</template>

<script lang="ts">
import Vue from 'vue'
import { isEmpty } from 'lodash'
import ChatState from '../../../State/ChatState'

import MessagesHeader from './MessagesHeader.vue'
import MessagesList from './MessagesList.vue'
import MessagesSend from './MessagesSend.vue'

export default Vue.extend({
  components: {
    MessagesHeader,
    MessagesList,
    MessagesSend
  },

  computed: {
    chat () {
      return ChatState.collectChat()
    },
    hasChat () {
      return !isEmpty(this.chat)
    }
  }
})
</script>
