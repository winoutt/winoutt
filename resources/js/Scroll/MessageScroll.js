import $ from 'jquery'
import { isEmpty } from 'lodash'
import MessageRequest from '../Request/MessageRequest'
import ChatState from '../State/ChatState'
import Scroll from './Scroll'
import MessageState from '../State/MessageState'

const config = {
  wrapper: '#messages-wrapper',
  content: '#messages',
  item: '.message-wrapper'
}

export default {
  toBottom () {
    Scroll.toBottom(config.wrapper, config.content)
  },

  paginate: {
    listen () {
      Scroll.onTop(config.wrapper, async () => {
        const chat = ChatState.collectChat()
        const nextPage = MessageState.collectNextPage()
        const scrollHeight = $(config.wrapper).prop('scrollHeight')
        const response = await MessageRequest.paginate(chat.id, nextPage)
        if (!isEmpty(response)) {
          const newScrollHeight = $(config.wrapper).prop('scrollHeight')
          const height = newScrollHeight - scrollHeight
          Scroll.to(config.wrapper, height)
        }
      })
    },
    leave () {
      Scroll.destroy(config.wrapper)
    }
  }
}
