<template lang="pug">
  .row.messages
    MessagesSidebar
    MessagesContent
</template>

<script lang="ts">
import Vue from 'vue'
import ChatRequest from '../Request/ChatRequest'
import MessageSocket from '../Socket/MessageSocket'
import Request from '../Request/Request'

import MessagesSidebar from '../components/views/messages/MessagesSidebar.vue'
import MessagesContent from '../components/views/messages/MessagesContent.vue'
import AuthRequest from '../Request/AuthRequest'
import MessageState from '../State/MessageState'
import ChatState from '../State/ChatState'

export default Vue.extend({
  components: {
    MessagesSidebar,
    MessagesContent
  },

  async beforeRouteEnter (to, from, next) {
    const requests = [
      AuthRequest.user(), // for socket channel
      ChatRequest.paginate(),
      ChatRequest.archived()
    ]
    const { isFailed } = await Request.bulk(requests)
    if (isFailed) return
    MessageSocket.listen.delivered()
    MessageSocket.listen.read()
    next()
  },

  beforeRouteLeave (to, from, next) {
    MessageState.pullMessages()
    ChatState.pullChat()
    next()
  }
})
</script>

<style lang="sass" scoped>
.messages
  height: calc(100vh - 87px)
</style>
