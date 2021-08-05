import { isEmpty } from 'lodash'
import MessageHttp from '../Http/MessageHttp'
import MessageState from '../State/MessageState'
import MessageScroll from '../Scroll/MessageScroll'
import ChatState from '../State/ChatState'

export default {
  async read (messageId) {
    const message = await MessageHttp.read(messageId)
    return message
  },
  async create (data) {
    const message = await MessageHttp.create(data)
    if (isEmpty(message)) return
    MessageState.addMessage(message)
    ChatState.replaceLastMessage(message)
    ChatState.moveToActive(data.chatId)
    ChatState.replaceTab('active')
    MessageScroll.toBottom()
    return message
  },

  async paginate (chatId, nextPage = false) {
    if (nextPage === null) return
    const messages = await MessageHttp.paginate(chatId, nextPage)
    if (isEmpty(messages)) return
    if (nextPage) MessageState.pushMessages(messages.data)
    else MessageState.replaceMessages(messages.data)
    MessageState.replaceNextPage(messages.next_page_url)
    return messages
  },

  async unreadsCount () {
    const { unreads_count: count } = await MessageHttp.unreadsCount()
    if (!count) return
    MessageState.replaceUnreadsCount(count)
  }
}
