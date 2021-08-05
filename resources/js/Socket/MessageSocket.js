import { isEmpty } from 'lodash'
import Socket from './Socket'
import UserState from '../State/UserState'
import MessageState from '../State/MessageState'
import MessageRequest from '../Request/MessageRequest'
import MessageScroll from '../Scroll/MessageScroll'
import ChatState from '../State/ChatState'
import ChatRequest from '../Request/ChatRequest'

function channel () {
  const user = UserState.collectUser()
  return `user.${user.id}`
}

const tracker = {
  created: false,
  delivered: false,
  read: false
}

export default {
  listen: {
    created: () => {
      if (Socket.isListening(tracker, 'created')) return
      Socket.safeBoot()
      Socket.echo.private(channel())
        .listen('.message.created', async data => {
          const { message_id: messageId } = data
          const message = await MessageRequest.read(messageId)
          if (isEmpty(message)) return
          MessageState.addMessage(message)
          ChatState.replaceLastMessage(message)
          ChatState.moveToActive(message.chat_id)
          MessageScroll.toBottom()
          const activeChat = ChatState.collectChat()
          const isActive = activeChat.pivot &&
            (activeChat.pivot.id === message.chat_id)
          if (isActive) ChatRequest.read(message.chat_id)
          else ChatRequest.markDelivered()
        })
    },
    delivered: () => {
      if (Socket.isListening(tracker, 'delivered')) return
      Socket.safeBoot()
      Socket.echo.private(channel())
        .listen('.message.delivered', data => {
          const { message_id: messageId } = data
          MessageState.deliveredMessage(messageId)
        })
    },
    read: () => {
      if (Socket.isListening(tracker, 'read')) return
      Socket.safeBoot()
      Socket.echo.private(channel())
        .listen('.message.read', data => {
          const { message_id: messageId } = data
          MessageState.readMessage(messageId)
        })
    }
  },

  leave () {
    if (Socket.echo) {
      tracker.created = false
      tracker.delivered = false
      tracker.read = false
      Socket.echo.leave(channel())
    }
  }
}
